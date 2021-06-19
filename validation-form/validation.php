<?php
    $login = filter_var(trim($_POST['login']),
    FILTER_SANITIZE_STRING);
    $password = filter_var(trim($_POST['password']),
    FILTER_SANITIZE_STRING);

    /*
    if (mb_strlen($login) < 5 || mb_strlen($login) > 40) {
        echo "Недопустимая длина логина";
        exit();
    } else if (mb_strlen($password) < 4 || mb_strlen($password) > 10) {
        echo "Недопустимая длина пароля (от 4 до 10 символов)";
        exit();
    }
    */

    $password = md5($password."lfy8d3sq1");

    $mysql = new mysqli('localhost', 'root', 'root', 'test-bd');
    
    $result = $mysql->query("SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
    $user = $result->fetch_assoc();
    if(count($user) == 0) {
        echo"Неверный логин или пароль";
        exit();
    }

    setcookie('user', $user['login'], time() + 10, "/");

    $mysql->close();

    /*
    header('Location: /main_page')
    header('location: /')
    */
?>