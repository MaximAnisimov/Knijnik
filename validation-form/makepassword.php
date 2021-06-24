<!DOCTYPE html> 
<html lang="en2">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSS -->
        <link rel="stylesheet" href="../css/style.css">
        <!-- Bootstrap CSS -->
        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous"> -->
        <link href="../bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>Главная</title>
    </head>
    <body>
        <div class="form modal1">
                <?php
                    $login = filter_var(trim($_POST['login']),
                    FILTER_SANITIZE_STRING);
                    $password = filter_var(trim($_POST['password']),
                    FILTER_SANITIZE_STRING);

                    echo ($login." - login\n");
                    echo ($password." - password\n");
                    $password = md5($password."lfy8d3sq1");
                    echo ($password." - md5 password\n");
                ?>
                <div class="flexcenter">
                <button  href="/index.php" class="mybtn1">Назад</button>
                </div>
        </div>
    </body>