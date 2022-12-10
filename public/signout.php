<?php
    include('../private/included_functions.php');
    // if user logs out then session_start() is called first to identify the session
    // then the session is destroyed and the user is redirected to index.php page
    session_start();
    session_destroy();
    $message = "Signed out";
    redirect_to('index.php');
?>