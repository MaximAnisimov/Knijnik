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
        //error_reporting(0);
        if($_COOKIE['worker_id'] == ''): //если нет cookie, открывается форма авторизации
      ?>
        <!-- форма авторизации -->
        <?php
          if($_COOKIE['error'] == 'wrongpass'): //если пароль был неправильно введен выводится алертбокс
        ?>
        <div class="errorbox">
          Неверный логин или пароль
        </div>
        <?php
          setcookie('error', 0, time() - 3600, "/");  
          endif;
        ?>
        <login-form>
          <div class="main-content, center">
              <form role="form" method="POST" action="php/login.php">
                  <div class="form-container form-login">
                      <label for="login"><b>Логин</b></label>
                      <input type="login" placeholder="Введите логин" name="login" id="login" required>
                      <label for="password"><b>Пароль</b></label>
                      <input type="password" placeholder="Введите пароль" name="password" id="password" required>
                      <button type="submit" class="formbtn-login">Войти</button>
                  </div>
              </form>
          </div>
        </login-form> 
      <?php
        else: //если есть cookie открывается главная страница web-сервиса
        //error_reporting(E_ALL);
        //ini_set("display_errors", 1);
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
          //echo json_encode($worker, JSON_UNESCAPED_UNICODE);
        }
          //$worker_name = $row["name"];
          //$worker_role = $row["role"];            
      ?>
        <!-- главная страница -->
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
                <li><a href="consumption.php" class="current">Расход</a></li>
                <li><a href="orders.php">Заказы</a></li>
                <li><a href="reporting.php">Отчетность</a></li>
                <li><a href="info.php">Инфо</a></li>
              </ul>
            </div>
          </nav>
          <main>
            
          </main>
          <footer>
            <div class="footer-content">
              <!--
              <div class="footer-box">
                <h4>Контактная Информация</h4>
                <a href="https://2gis.ru/surgut/firm/5489290326876712">г. Сургут ул. Маяковского, 14</a><br>
                <a href="mailto:surgut@pm-tipograf.ru">surgut@pm-tipograf.ru</a><br>
                <a href="tel:+73462375540">+7 (3462) 37-55-40</a>
              </div>
              -->
              <div class="footer-box footer-box-right">
                <!--<h4>О разработчике</h4>-->
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

      <!-- Optional JavaScript; Bootstrap Bundle with Popper
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
      -->
      <!--  <script src="/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
    </body>
</html>