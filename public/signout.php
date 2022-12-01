<?php
    include('../private/included_functions.php');
    session_start();
    session_destroy();
    $message = "Signed out";
    redirect_to('index.php');
?>