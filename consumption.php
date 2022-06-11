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
        setcookie('ordersearchtext', $ordersearchtext, time() - 3600, "/");
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
        <!-- страница расход -->
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
                echo '<li><a href="consumption.php" class="current">Расход</a></li>';
                echo '<li><a href="orders.php">Заказы</a></li>';
                echo '<li><a href="reporting.php">Отчетность</a></li>';
                echo '<li><a href="info.php">Инфо</a></li>';
                } else if($worker_role == 'Кладовщик') {
                echo '<li><a href="/">Склад</a></li>';
                echo '<li><a href="supplies.php">Приемка товара</a></li>';
                echo '<li><a href="consumption.php" class="current">Расход</a></li>';
                echo '<li><a href="reporting.php">Отчетность</a></li>';
                echo '<li><a href="info.php">Инфо</a></li>';
                } else if($worker_role == 'Продавец') {
                echo '<li><a href="/">Склад</a></li>';
                echo '<li><a href="consumption.php" class="current">Расход</a></li>';
                echo '<li><a href="orders.php">Заказы</a></li>';
                echo '<li><a href="reporting.php">Отчетность</a></li>';
                echo '<li><a href="info.php">Инфо</a></li>';
                }?>
              </ul>
            </div>
          </nav>
          <main>
            <div class="main-content">
              <form role="form" method="POST" action="">
                <div class="form-container form-search form-consumption-type">
                  <button type="submit" name="btn_consumption_type_sale" id="btn_consumption_type_sale" class="formbtn-search <?php if( $_COOKIE['consumption_type'] == 'sale') echo "formbtn-current" ?>">Продажа</button>
                  <button type="submit" name="btn_consumption_type_writeoff" id="btn_consumption_type_writeoff" class="formbtn-search <?php if($_COOKIE['consumption_type'] == 'writeoff') echo "formbtn-current" ?>">Списание</button>
                </div>
                <?php
                      function btn_consumption_type_sale()
                      {
                        setcookie('consumption_type', 'sale', time() + 3600, "/");
                        header("Refresh:0");
                      }
                      if(array_key_exists('btn_consumption_type_sale',$_POST)){
                        btn_consumption_type_sale();
                      }
                      function btn_consumption_type_writeoff()
                      {
                        setcookie('consumption_type', 'writeoff', time() + 3600, "/");
                        header("Refresh:0");
                      }
                      if(array_key_exists('btn_consumption_type_writeoff',$_POST)){
                        btn_consumption_type_writeoff();
                      }
                  ?>
              </form>
              <?php if($_COOKIE['consumption_type'] == '') {
                } else {?>
                <form role="form" method="POST" action="" class="padding-eight">
                  <div class="form-container form-search form-consumption">
                    <p>Указать
                      <select name="serach-type" id="serach-type">
                        <option selected value="code">Артикул</option>
                        <option value="product_name">Наименование</option>
                        <option value="barcode">Штрихкод</option>
                      </select>
                    </p>
                    <input type="search-text" placeholder="Идентификатор" name="search-text" id="search-text" required>
                    <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" placeholder="Кол-во" name="search-number" id="search-number"  maxlength="3" required>
                    <button type="submit" name="btn_consumption" id="btn_consumption" class="formbtn-search">Оформить</button>
                  </div>
                  <?php
                      function btn_consumption()
                      {
                        $serachtype = filter_input(INPUT_POST, 'serach-type', FILTER_SANITIZE_STRING);
                        $worker_id = filter_var(trim($_COOKIE["worker_id"]),FILTER_SANITIZE_STRING);/*нужно ли*/
                        $consumptionsearchtext = filter_var(trim($_POST['search-text']), FILTER_SANITIZE_STRING);
                        $consumptionsearchnumber = filter_var(trim($_POST['search-number']), FILTER_SANITIZE_STRING);

                        if($_COOKIE['consumption_type'] == 'sale') {$consumptiontype="продажа";}
                        if($_COOKIE['consumption_type'] == 'writeoff') {$consumptiontype="списание";}
                        $date = date('Y-m-d H:i:s');
                        $link = new mysqli('localhost', 'root', 'root', 'knizhnik_db');
                        $result = $link->query("SELECT * FROM products WHERE $serachtype like '%$consumptionsearchtext%'");
                        $product = $result->fetch_assoc();
                        $product_id = $product['product_id'];
                        $sql = "INSERT IGNORE INTO `consumption` (`worker_id`, `product_id`, `quantity`, `consumption_type`, `consumption_date`) VALUES ('$worker_id', '$product_id', '$consumptionsearchnumber', '$consumptiontype', '$date')";
                        if (mysqli_query($link, $sql)) {
                          setcookie('message', '1', time() + 3, "/");
                        }
                        header("Refresh:0");
                      }
                      if(array_key_exists('btn_consumption',$_POST)){
                        btn_consumption();
                      }
                    ?>
                    <?php if($_COOKIE['message'] == '1') { echo '<div class="order-message">Запись успешно создана '; } else { }?>
                </form>
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