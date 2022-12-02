<!-- Allow users to login using a form with inputs for email and password   -->

<?php
include('../private/included_functions.php');
require_once("../private/database.php");
require_SSL();

if (!isset($_POST["submit"])) {
    $email = $password = "";
} else {
    if (!empty($_POST["email"])) {
        $email = trim($_POST["email"]);
    } else {
        $email = "";
    }
    if (!empty($_POST["password"])) {
        $password = trim($_POST["password"]);
    } else {
        $password = "";
    }

    $query = "SELECT password FROM users WHERE email = \"$email\"";
    $result = mysqli_query($db, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $pass_hash = $row["password"];
    }
    if (!empty($pass_hash) && password_verify($password, $pass_hash)) {
        session_start();
        $_SESSION['valid_user'] = $email;
        $callback_url = "index.php";
        if (isset($_SESSION['callback_url'])) {
            $callback_url = $_SESSION['callback_url'];
        }
        redirect_to($callback_url);
    } else {
        $message = "Sorry, email and password combination not registered.";
    }
}

require_once('../private/shared/public_header.php');
?>

<form class="login" action="login.php" method="post">
    <h1 class="display-large">Welcome</h1>
    <?php if (!empty($message)) echo '<p style="text-align: center">' . $message . '</p>' ?>
    <input type="email" name="email" placeholder="Please Enter Your Email Adress" value="<?php $email ?>">
    <br />
    <input type="password" name="password" placeholder="Please Enter Your Password" value="">
    <br />
    <input type="submit" name="submit" value="Login">
    <p><a href="signup.php">Not registered yet? Register here.</a></p>
</form>

<?php
require_once('../private/shared/public_footer.php');
mysqli_close($db);
?>