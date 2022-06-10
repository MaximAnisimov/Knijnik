<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <title>Главная</title>
  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="css/styles.css">
</head>
    <body>
      <?php
        setcookie('serachtype', $serachtype, time() - 3600, "/");
        setcookie('stocksearchtext', $stocksearchtext, time() - 3600, "/");
        setcookie('consumption_type', $consumption_type, time() - 3600, "/");
        setcookie('reporting_type', $consumption_type, time() - 3600, "/");
        if($_COOKIE['worker_id'] == ''): //если нет cookie   
          header('location: /');
        else: //если есть cookie
        $link = new mysqli('localhost', 'root', 'root', 'knizhnik_db');
        if (!$link) {
            echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
            exit;
        }
        if ($link) {
          $worker_id = filter_var(trim($_COOKIE["worker_id"]),FILTER_SANITIZE_STRING);
          $result = $link->query("SELECT * FROM `workers` WHERE `worker_id` = '$worker_id'");
          $worker = $result->fetch_assoc();
          $worker_name = $worker['worker_name'];
          $worker_role = $worker['role'];
        }           
      ?>
        <!-- страница заказы -->
        <div class="container contain" id="container">
          <header id="header">
              <img src="images/logo_wide.png" class="logo"/>
              <h1>Книги для всей семьи!</h1>
              <div class="header-worker">
                <div class="header-box-left"><a href="XXX.php" class="header-name"><?php echo $worker_name; ?> — <?php echo $worker_role; ?></a></div>
                <div class="header-box-right"><a href="php/exit.php" class="logout">Выйти</a></div>
              </div>
          </header>
          <nav id="nav">
            <div class="nav-content nav-scroll">
              <ul class="nav-menu">
                <li><a href="/">Склад</a></li>
                <li><a href="supplies.php">Приемка товара</a></li>
                <li><a href="consumption.php">Расход</a></li>
                <li><a href="orders.php" class="current">Заказы</a></li>
                <li><a href="reporting.php">Отчетность</a></li>
                <li><a href="info.php">Инфо</a></li>
              </ul>
            </div>
          </nav>
          <main>
            <div class="main-content">
              <form role="form" method="POST" action="">
                  <div class="form-container form-search form-search-two-buttons">
                    <p>Введите номер заказа
                    </p>
                    <input type="search-text" placeholder="" name="search-text" id="search-text">
                    <button type="submit" name="btn_order" id="btn_order" class="formbtn-search">Поиск</button>
                    <button type="submit" name="btn_reset" id="btn_reset" class="formbtn-search">Сброс</button>
                  </div>
                  <?php
                      function btn_order()
                      {
                        $ordersearchtext = filter_var(trim($_POST['search-text']), FILTER_SANITIZE_STRING);
                        setcookie('ordersearchtext', $ordersearchtext, time() + 3600, "/");
                        header("Refresh:0");
                      }
                      if(array_key_exists('btn_order',$_POST)){
                        btn_order();
                      }
                      function btn_reset()
                      {
                        setcookie('ordersearchtext', $ordersearchtext, time() - 3600, "/");
                        header("Refresh:0");
                      }
                      if(array_key_exists('btn_reset',$_POST)){
                        btn_reset();
                      }
                    ?>
              </form>
                    <?php
                      if($_COOKIE['ordersearchtext'] == '') {
                      }
                      else {
                        $link = new mysqli('localhost', 'root', 'root', 'knizhnik_db');
                        if (!$link) {
                            echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
                            exit;
                        }
                        if ($link) {
                          /* Все варианты сортировки */
                          $sort_list = array(
                            'code_asc'   => '`code`',
                            'code_desc'  => '`code` DESC',
                            'barcode_asc'  => '`barcode`',
                            'barcode_desc' => '`barcode` DESC',
                            'product_name_asc'   => '`product_name`',
                            'product_name_desc'  => '`product_name` DESC',
                            'sell_price_asc'   => '`sell_price`',
                            'sell_price_desc'  => '`sell_price` DESC',
                            'order_quantity_asc'   => '`order_quantity`',
                            'order_quantity_desc'  => '`order_quantity` DESC',
                          );
                          /* Проверка GET-переменной */
                          $sort = @$_GET['sort'];
                          if (array_key_exists($sort, $sort_list)) {
                            $sort_sql = $sort_list[$sort];
                          } 
                          else {
                            $sort_sql = reset($sort_list);
                          }
                          /* Запрос */
                          $ordersearchtext =  $_COOKIE['ordersearchtext'];
                          $sql = "SELECT orders.order_number, orders.order_quantity, products.code,  products.barcode, products.product_name, products.sell_price
                                  FROM orders
                                  LEFT JOIN products
                                  ON products.product_id=orders.product_id
                                  WHERE order_number=$ordersearchtext
                                  ORDER BY $sort_sql";
                          /* Запрос в БД */
                          $dbh = new PDO('mysql:dbname=knizhnik_db;host=localhost', 'root', 'root');
                          $sth = $dbh->prepare($sql);
                          $sth->execute();
                          $list = $sth->fetchAll(PDO::FETCH_ASSOC);
                          /* Функция вывода ссылок */
                          function sort_link_th($title, $a, $b) {
                            $sort = @$_GET['sort'];
                            if ($sort == $a) {
                              return '<a class="active" href="?sort=' . $b . '">' . $title . ' <i>▲</i></a>';
                            } elseif ($sort == $b) {
                              return '<a class="active" href="?sort=' . $a . '">' . $title . ' <i>▼</i></a>';  
                            } else {
                              return '<a href="?sort=' . $a . '">' . $title . '</a>';  
                            }
                          }
                        }
                      }
                    ?>
                    <?php if($_COOKIE['ordersearchtext'] == '') {
                    } else { ?>
                    <div class="table-container table-scroll">
                          <table>
                          <tr>
                            <th>№</th>
                            <th><?php echo sort_link_th("Артикул", "code_asc", "code_desc"); ?></th>
                            <th><?php echo sort_link_th("Штрихкод", "barcode_asc", "barcode_desc"); ?></th>
                            <th><?php echo sort_link_th("Наименование", "product_name_asc", "product_name_desc"); ?></th>
                            <th><?php echo sort_link_th("Цена за Шт.", "sell_price_asc", "sell_price_desc"); ?></th>
                            <th><?php echo sort_link_th("Кол-во", "order_quantity_asc", "order_quantity_asc_desc"); ?></th>
                            <th>Стоимость</th>
                          </tr>
                          <?php $count=1; foreach ($list as $row): ?>
                          <tr>
                            <td><?php echo $count; $count=$count+1; ?></td>
                            <td><?php echo $row["code"] ?></td>
                            <td><?php echo $row["barcode"] ?></td>
                            <td><?php echo $row["product_name"] ?></td>
                            <td><?php echo $row["sell_price"],' ₽' ?></td>
                            <td><?php echo $row["order_quantity"] ?></td>
                            <td><?php $cost=$row["sell_price"]*$row["order_quantity"]; $totalcost=$totalcost+$cost; echo $cost+".00 ₽" ?></td>
                          </tr>
                          <?php endforeach ?>
                          </table>
                        </div>
                    <?php echo '<div class="order-message">Заказ номер ',$ordersearchtext,'<br>ИТОГО: ',$totalcost,' ₽</div>'; } ?>
            </div>
          </main>
          <footer>
            <div class="footer-content">
              <div class="footer-box footer-box-right">
                <div>Разработано Анисимовым Максимом</div>
                <div>Компания Печатный Мир г. Сургут</div>
              </div>
            </div>
          </footer>
          <script>
            // скрипт для липкой навигации
            $(document).ready(function () {
                const nav = $('#nav');
                const navOffset = nav.offset().top;
                const navHeight = nav.height();
                $(window).scroll(function(){
                    const scrolled = $(this).scrollTop();
                    if (scrolled > navOffset) {
                        $('#container').addClass('nav-fixed');
                        $('#header').css({marginBotton: navHeight});
                    }
                    else if (scrolled < navOffset) {
                        $('#container').removeClass('nav-fixed');
                        $('#header').css({marginBotton: 0});
                    }
                });
            });
          </script>
        </div>
      <?php
        endif;
      ?>
    </body>
</html>