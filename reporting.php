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
        setcookie('searchtext', $ssearchtext, time() - 3600, "/");
        setcookie('ordersearchtext', $ordersearchtext, time() - 3600, "/");
        setcookie('consumption_type', $consumption_type, time() - 3600, "/");
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
        <!-- страница отчетность -->
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
                <?php if($worker_role == 'Администратор') {
                  echo '<li><a href="/">Склад</a></li>';
                  echo '<li><a href="supplies.php">Приемка товара</a></li>';
                  echo '<li><a href="consumption.php">Расход</a></li>';
                  echo '<li><a href="orders.php">Заказы</a></li>';
                  echo '<li><a href="reporting.php" class="current">Отчетность</a></li>';
                  echo '<li><a href="info.php">Инфо</a></li>';
                  } else if($worker_role == 'Кладовщик') {
                  echo '<li><a href="/">Склад</a></li>';
                  echo '<li><a href="supplies.php">Приемка товара</a></li>';
                  echo '<li><a href="consumption.php">Расход</a></li>';
                  echo '<li><a href="reporting.php" class="current">Отчетность</a></li>';
                  echo '<li><a href="info.php">Инфо</a></li>';
                  } else if($worker_role == 'Продавец') {
                  echo '<li><a href="/">Склад</a></li>';
                  echo '<li><a href="consumption.php">Расход</a></li>';
                  echo '<li><a href="orders.php">Заказы</a></li>';
                  echo '<li><a href="reporting.php" class="current">Отчетность</a></li>';
                  echo '<li><a href="info.php">Инфо</a></li>';
                }?>
              </ul>
            </div>
          </nav>
          <main>
            <div class="main-content">
              <form role="form" method="POST" action="">
                <div class="form-container form-search form-reporting-type">
                  <button type="submit" name="btn_reporting_type_personal" id="btn_reporting_type_personal" class="formbtn-search <?php if( $_COOKIE['reporting_type'] == 'personal') echo "formbtn-current" ?>">Личная</button>
                  <?php if ($worker_role == 'Администратор'): ?>
                    <button type="submit" name="btn_reporting_type_general" id="btn_reporting_type_general" class="formbtn-search <?php if($_COOKIE['reporting_type'] == 'general') echo "formbtn-current" ?>">Общая</button>
                  <?php endif; ?>
                </div>
                <?php
                      function btn_reporting_type_personal()
                      {
                        setcookie('reporting_type', 'personal', time() + 3600, "/");
                        header("Refresh:0");
                      }
                      if(array_key_exists('btn_reporting_type_personal',$_POST)){
                        btn_reporting_type_personal();
                      }
                      function btn_reporting_type_general()
                      {
                        setcookie('reporting_type', 'general', time() + 3600, "/");
                        header("Refresh:0");
                      }
                      if(array_key_exists('btn_reporting_type_general',$_POST)){
                        btn_reporting_type_general();
                      }
                  ?>
              </form>
              <?php if($_COOKIE['reporting_type'] == '') {
                } else {?>
                <form role="form" method="POST" action="" class="padding-eight">
                  <div class="form-container form-search form-reporting">  
                    Выберите период
                    <br>C
                    <input type="date" name="reporting-from" id="reporting-from">
                    по
                    <input type="date" name="reporting-to" id="reporting-to">
                    <button type="submit" name="btn_reporting" id="btn_reporting" class="formbtn-search">Отчет</button>
                    <button type="submit" name="btn_reset" id="btn_reset" class="formbtn-search reporting-btn">Сброс</button>
                  </div>
                  <?php
                    function btn_reporting()
                    {
                      $reporting_from = filter_var(trim($_POST['reporting-from']), FILTER_SANITIZE_STRING);
                      setcookie('reporting_from', $reporting_from, time() + 1, "/");
                      $reporting_to = filter_var(trim($_POST['reporting-to']), FILTER_SANITIZE_STRING);
                      setcookie('reporting_to', $reporting_to, time() + 1, "/");
                      header("Refresh:0");
                    }
                    if(array_key_exists('btn_reporting',$_POST)){
                      btn_reporting();
                    }
                    function btn_reset()
                      {
                        setcookie('reporting_from', $reporting_from, time() - 3600, "/");
                        setcookie('reporting_to', $reporting_to, time() - 3600, "/");
                        header("Refresh:0");
                      }
                      if(array_key_exists('btn_reset',$_POST)){
                        btn_reset();
                      }
                  ?>
                </form>
                <?php
                  if($_COOKIE['reporting_from'] == '') {
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
                            'quantity_asc'   => '`quantity`',
                            'quantity_desc'  => '`quantity` DESC',
                            'worker_name_asc'   => '`worker_name`',
                            'worker_name_desc'  => '`worker_name` DESC',
                            'consumption_date_asc'   => '`consumption_date`',
                            'consumption_date_desc'  => '`consumption_date` DESC',
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
                      $reporting_from =  $_COOKIE['reporting_from'];
                      $reporting_to =  $_COOKIE['reporting_to'];
                      if ($_COOKIE['reporting_type'] == 'general') { $sql = "SELECT consumption.*, products.code, products.barcode, products.product_name, products.sell_price, workers.worker_name
                                                                              FROM consumption
                                                                              LEFT JOIN products
                                                                              ON consumption.product_id=products.product_id
                                                                              LEFT JOIN workers
                                                                              ON consumption.worker_id=workers.worker_id
                                                                              WHERE consumption.consumption_date BETWEEN '$reporting_from' AND DATE_ADD('$reporting_to', INTERVAL 1 DAY)
                                                                              AND consumption.consumption_type='продажа'
                                                                              ORDER BY $sort_sql"; }
                      if ($_COOKIE['reporting_type'] == 'personal') { $sql = "SELECT consumption.*, products.code, products.barcode, products.product_name, products.sell_price, workers.worker_name
                                                                              FROM consumption
                                                                              LEFT JOIN products
                                                                              ON consumption.product_id=products.product_id
                                                                              LEFT JOIN workers
                                                                              ON consumption.worker_id=workers.worker_id
                                                                              WHERE consumption.consumption_date BETWEEN '$reporting_from' AND DATE_ADD('$reporting_to', INTERVAL 1 DAY)
                                                                              AND consumption.consumption_type='продажа'
                                                                              AND workers.worker_name='$worker_name'
                                                                              ORDER BY $sort_sql"; }
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
                    ?>
                  <div class="table-container table-scroll">
                    <table>
                      <tr>
                        <th>№</th>
                        <th><?php echo sort_link_th("Артикул", "code_asc", "code_desc"); ?></th>
                        <th><?php echo sort_link_th("Штрихкод", "barcode_asc", "barcode_desc"); ?></th>
                        <th><?php echo sort_link_th("Наименование", "product_name_asc", "product_name_desc"); ?></th>
                        <th><?php echo sort_link_th("Тип расхода", "consumption_type_asc", "consumption_type_desc"); ?></th>
                        <th><?php echo sort_link_th("Цена за Шт.", "sell_price_asc", "sell_price_desc"); ?></th>
                        <th><?php echo sort_link_th("Кол-во", "quantity_asc", "quantity_desc"); ?></th>
                        <th>Стоимость</th>
                        <?php if ($_COOKIE['reporting_type'] == 'general'): ?>
                        <th><?php echo sort_link_th("Работник", "worker_name_asc", "worker_name_desc"); ?></th>
                        <?php endif; ?>
                        <th><?php echo sort_link_th("Дата", "consumption_date_asc", "consumption_date_desc"); ?></th>
                      </tr>
                      <?php $count=1; foreach ($list as $row): ?>
                      <tr>
                        <td><?php echo $count; $count=$count+1; ?></td>
                        <td><?php echo $row["code"] ?></td>
                        <td><?php echo $row["barcode"] ?></td>
                        <td><?php echo $row["product_name"] ?></td>
                        <td><?php echo $row["consumption_type"] ?></td>
                        <td><?php echo $row["sell_price"],' ₽'; ?></td>
                        <td><?php echo $row["quantity"] ?></td>
                        <td><?php $cost=$row["sell_price"]*$row["quantity"]; $totalcost=$totalcost+$cost; echo $cost,".00 ₽"; ?></td>
                        <?php if ($_COOKIE['reporting_type'] == 'general'): ?>
                        <td><?php echo $row["worker_name"] ?></td>
                        <?php endif; ?>
                        <td><?php echo $row["consumption_date"] ?></td>
                      </tr>
                      <?php endforeach ?>
                    </table>
                    </div>
                  <?php if ($_COOKIE['reporting_type'] == 'general') { echo '<div class="order-message">Общие продажи<br>ИТОГО: ',$totalcost,' ₽</div>'; } else { echo '<div class="order-message">Личные продажи<br>ИТОГО: ',$totalcost,' ₽</div>'; }
                  }
                ?>
              <?php } ?>
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