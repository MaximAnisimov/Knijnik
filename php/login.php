<?php
    $login = filter_var(trim($_POST['login']),
    FILTER_SANITIZE_STRING);
    $password = filter_var(trim($_POST['password']),
    FILTER_SANITIZE_STRING);
    $password = md5($password."lfy8d3sq1");

    /*
    if (mb_strlen($login) < 5 || mb_strlen($login) > 40) {
        echo "Недопустимая длина логина";
        exit();
    } else if (mb_strlen($password) < 4 || mb_strlen($password) > 10) {
        echo "Недопустимая длина пароля (от 4 до 10 символов)";
        exit();
    }
    */    

    $link = new mysqli('localhost', 'root', 'root', 'knizhnik_db');
    if (!$link) {
        echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    }
    
    $result = $link->query("SELECT * FROM `workers` WHERE `login` = '$login' AND `password` = '$password'");
    $worker = $result->fetch_assoc();
    /*if(count($worker) == 0) {
        echo"Неверный логин или пароль";
        echo"<br>Введеный логин - ",$login;
        echo"<br>Введеный пароль - ",$password;
        exit();
    }
    */
    if(count($worker) == 0) {
        setcookie('error', 'wrongpass', time() + 3, "/");
        header('location: /');
        exit();
    }

    setcookie('worker_id', $worker['worker_id'], time() + 3600, "/");

    $link->close();

    header('location: /')
?>