<!-- All required function goes here -->

<?php

    // checks if https is on
    // if on then changes to http for insecure connection
    function no_SSL() {
        if(isset($_SERVER['HTTPS']) &&  $_SERVER['HTTPS']== "on") {
            header("Location: http://" . $_SERVER['HTTP_HOST'] .
                $_SERVER['REQUEST_URI']);
            exit();
        }
    }

    // checks if http is on
    // if on then changes to https for secure connection
    function require_SSL() {
        if($_SERVER['HTTPS'] != "on") {
            header("Location: https://" . $_SERVER['HTTP_HOST'] .
                $_SERVER['REQUEST_URI']);
            exit();
        }
    }

    // redirects to the passed url
    function redirect_to($url) {
        header('Location: ' . $url);
        exit;
    }

    // checks if the user is logged in or not
    function is_logged_in() {
        return isset($_SESSION['valid_user']);
    }

    // checks if the product is in the watchlist or not
    function is_in_watchlist($code) {
        global $db;
        if (isset($_SESSION['valid_user'])) {
            $query = "SELECT COUNT(*) 
                      FROM watchlist 
                      WHERE productCode=? 
                      AND email=?";
            $stmt = $db->prepare($query);
            $stmt->bind_param('ss',$code, $_SESSION['valid_user']);
            $stmt->execute();
            $stmt->bind_result($count);
            return ($stmt->fetch() && $count > 0);
        }
        return false;
    }

    // formats the name of the model as a link
    function format_model_name_as_link($id,$name,$page) {
        echo "<a href=\"$page?productCode=$id\">$name</a>";
    }

    // formats the watchlist items as a link
    function format_watchlist_action_link($id,$name,$page) {
        echo "<a class=\"remove\" href=\"$page?productCode=$id\">$name</a>";
    }
?>