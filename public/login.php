<?php
// <!-- Allow users to login using a form with inputs for email and password   -->
include('../private/included_functions.php');
require_once("../private/database.php");
require_SSL();

// valid inputs are checked and the current user is verified from the database before allowing into the website
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

    // verifies user from the database
    $query = "SELECT password FROM users WHERE email = \"$email\"";
    $result = mysqli_query($db, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $pass_hash = $row["password"];
    }
    if (!empty($pass_hash) && password_verify($password, $pass_hash)) {
        // if verified, a session is created using the user's email
        // and the user will be redirected to the page from where he was originally redirected from
        session_start();
        $_SESSION['valid_user'] = $email;
        $callback_url = "index.php";
        if (isset($_SESSION['callback_url'])) {
            $callback_url = $_SESSION['callback_url'];
        }
        redirect_to($callback_url);
    } else {
        // if failed a message is displayed
        $message = "Sorry, email and password combination not registered.";
    }
}

require_once('../private/shared/public_header.php');
?>

<form class="login" action="login.php" method="post">
    <h1 class="display-large">Welcome</h1>
    <?php if (!empty($message)) echo '<p style="text-align: center">' . $message . '</p>' ?>
    <input class="title-medium" type="email" name="email" placeholder="Please Enter Your Email Adress" value="<?php $email ?>" required>
    <br />
    <input class="title-medium" type="password" name="password" placeholder="Please Enter Your Password" value="" required>
    <br />
    <input class="title-large" type="submit" name="submit" value="Login">
    <p ><a href="signup.php">Not registered yet? Register here.</a></p>
</form>

<?php
require_once('../private/shared/public_footer.php');
mysqli_close($db);
?>