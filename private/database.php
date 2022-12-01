<!-- Database related functions goes here -->
<?php
    require_once('database_credentials.php');

    // returns connection to the database if credentials are correct otherwise displays an error
    function connectToDB($dbhost, $dbuser, $dbpass, $dbname) {
        $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        //did connection occur database?
        if (mysqli_connect_errno()) {
            //quit and display error and error number
            die("Database connection failed:" .
                mysqli_connect_error() .
                " (" . mysqli_connect_errno() . ")"
            );
        }
        return $connection;
    }

    $db = connectToDB($dbhost, $dbuser, $dbpass, $dbname);

?>