<?php
    setcookie('worker_id', $worker['worker_id'], time() - 3600, "/");
    setcookie('serachtype', $serachtype, time() - 3600, "/");
    setcookie('stocksearchtext', $stocksearchtext, time() - 3600, "/");
    header('location: /')
?>