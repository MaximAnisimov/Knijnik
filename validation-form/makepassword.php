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