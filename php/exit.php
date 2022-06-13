<?php
    setcookie('worker_id', $worker['worker_id'], time() - 3600, "/");
    setcookie('serachtype', $serachtype, time() - 3600, "/");
    setcookie('stocksearchtext', $stocksearchtext, time() - 3600, "/");
    setcookie('ordersearchtext', $ordersearchtext, time() - 3600, "/");
    setcookie('consumption_type', $consumption_type, time() - 3600, "/");
    setcookie('reporting_from', $reporting_from, time() - 3600, "/");
    setcookie('reporting_to', $reporting_to, time() - 3600, "/");
    header('location: /')
?>