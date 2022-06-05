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
                  <div class="form-container form-search">
                    <p>Введите номер заказа
                    </p>
                    <input type="search-text" placeholder="" name="search-text" id="search-text" required>
                    <button type="submit" name="btn_order" id="btn_order" class="formbtn-search">Поиск</button>
                  </div>
                  <?php
                      function btn_order_function()
                      {
                        $ordersearchtext = filter_var(trim($_POST['search-text']), FILTER_SANITIZE_STRING);
                        setcookie('ordersearchtext', $ordersearchtext, time() + 5, "/");
                        header("Refresh:0");
                      }
                      if(array_key_exists('btn_order',$_POST)){
                        btn_order_function();
                      }
                    ?>
              </form>
                    <?php
                      if($_COOKIE['ordersearchtext'] == '') {
                      }
                      else {
                        echo '<div class="table-container table-scroll"> 
                                <table>
                                  <tr>
                                    <th>№</th>
                                    <th>Артикул</th>
                                    <th>Штрихкод</th>
                                    <th>Наименование</th>
                                    <th>Цена за Шт.</th>
                                    <th>Кол-во</th>
                                    <th>Стоимость</th>
                                  </tr>';
                        $serachtype = $_COOKIE['serachtype'];
                        $ordersearchtext =  $_COOKIE['ordersearchtext'];
                        $link = new mysqli('localhost', 'root', 'root', 'knizhnik_db');
                        if (!$link) {
                            echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
                            exit;
                        }
                        if ($link) {
                          $sql = "SELECT orders.order_number, orders.order_quantity, products.code,  products.barcode, products.product_name, products.sell_price
                                  FROM orders
                                  LEFT JOIN products
                                  ON products.product_id=orders.product_id
                                  WHERE order_number=$ordersearchtext";
                          //Отобразить данные из БД на web-странице в виде таблицы
                          if($result = $link->query($sql)) {
                              $count=1;
                              $totalcost=0;
                              foreach($result as $row) {//тут данные из таблицы в бд вносятся в таблицу на html страницу
                              echo "<tr>";
                              echo "<td>".$count."</td>";
                              $count=$count+1;
                              echo "<td>".$row["code"]."</td>";
                              echo "<td>".$row["barcode"]."</td>";
                              echo "<td>".$row["product_name"]."</td>";
                              echo "<td>".$row["sell_price"]." ₽</td>";
                              echo "<td>".$row["order_quantity"]."</td>";
                              $cost=$row["sell_price"]*$row["order_quantity"];
                              $totalcost=$totalcost+$cost;
                              echo "<td>".$cost.".00 ₽</td>";
                              echo "</tr>"; 
                              }
                          }
                            echo "</table> ";
                            echo "</div>";
                            echo '<div class="order-message">Заказ номер ',$ordersearchtext,'<br>ИТОГО: ',$totalcost,' ₽</div>';
                        }
                      }
                    ?>
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