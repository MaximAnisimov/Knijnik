<!DOCTYPE html> 
<html lang="en2">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSS -->
        <link rel="stylesheet" href="css/style.css">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <title>Главная</title>
    </head>
    <body>

      <?php 
        if($_COOKIE['user'] == ''): //если нет cookie, открывается форма авторизации
      ?>
        <!-- форма авторизации -->
        <div class="form modal1">
          <form class="form-horizontal" role="form" action="validation-form/validation.php" method="POST">
            <div class="form-group style1">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Логин</label>
                <div>
                  <input type="text" class="form-control" placeholder="Логин" name="login">
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Пароль</label>
                <div>
                  <input type="password" class="form-control" placeholder="Пароль" name="password">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="not_attach_ip" class="azuretext"> Запомнить пароль (не безопасно)
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="flexcenter">
                  <button type="submit" class="btn btn-default"></a>Войти</button>
                </div>
              </div>
            </div>  
          </form>
        </div>
      <?php
        else: //если есть cookie открывается главная страница web-сервиса
      ?>
        <!-- главная страница -->
        <div class="header">    
          <ul class="nav col-12 col-md-auto justify-content-center mb-md-0 style6">
            <li><img class="style4" src="images/logo_placeholder.png" width="55" height="55"></li>
            <!--<li class="style1"><a href="#" class="nav-link px-2 link-dark">LOGO</a></li>-->
            <li class="style2 style7"><a href="#" class="nav-link px-2 link-dark headertext">Склад</a></li>
            <li class="style2 style7"><a href="#" class="nav-link px-2 link-dark headertext">Заказы</a></li>
            <li class="style7"><a href="#" class="nav-link px-2 link-dark headertext">Информация</a></li>
          </ul>
        </div>
        <img class="modal1" src="images/logo_placeholder.png" width="250" height="250">
        <div class="footer col-12">
          <ul class="nav col-12 col-md-auto justify-content-center mb-md-0">
          <li class="style2 style7"><a href="#" class="nav-link px-2 footertext style3">Техподдержка: +(ХХХ) ХХХ-ХХ-ХХ<br>Менеджер: +(ХХХ) ХХХ-ХХ-ХХ</a></li>
          <li class="style7"><img class="px-2 style5" src="images/logo_placeholder.png" width="55" height="55" alt="Пример"></li>
          <!--<li class="style1"><a href="#" class="nav-link px-2 style2">LOGO</a></li>-->
          </ul>
        </div>
      <?php
        endif;
      ?>

      <!-- Optional JavaScript; Bootstrap Bundle with Popper
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
      -->
    </body>
</html>