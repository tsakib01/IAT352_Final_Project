<!-- Allow users to register using a form with inputs for email, fname, lname, password, confirm password   -->
<?php
include('../private/included_functions.php');
require_once("../private/database.php");
require_SSL();

if (isset($_POST['submit'])) {
    if (!empty($_POST["fname"])) {
        $fname = trim($_POST["fname"]);
    } else {
        $fname = "";
    }
    if (!empty($_POST["lname"])) {
        $lname = trim($_POST["lname"]);
    } else {
        $lname = "";
    }
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
    if (!empty($_POST["password2"])) {
        $password2 = trim($_POST["password2"]);
    } else {
        $password2 = "";
    }

    if ($password != $password2) {
        $message = "Your entered passwords do not match.";
    } else if (!$fname || !$lname || !$email || !$password) {
        $message = "Missing information.";
    } else {
        $pw_encrypted = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (email,fname,lname,password) VALUES (?,?,?,?)";

        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $email, $fname, $lname, $pw_encrypted);
        mysqli_stmt_execute($stmt);
        redirect_to('login.php');
    }
} else {
    $fname = "";
    $lname = "";
    $email = "";
    $password = "";
    $password2 = "";
}

require_once('../private/shared/public_header.php');
?>

<form class="signup" action="signup.php" method="post">
    <h1 class="display-large">Sign Up</h1>
    <?php if (!empty($message)) echo "<p class=\"title-medium\">" . $message . '</p>' ?>
    <input class="title-medium" name="fname" type="text" placeholder="Please Enter Your First Name" value="<?php $fname ?>">
    <br />
    <input class="title-medium" type="text" name="lname" placeholder="Please Enter Your Last Name" value="<?php $lname ?>">
    <br />
    <input class="title-medium" type="email" name="email" placeholder="Please Enter Your Email Adress" value="<?php $email ?>">
    <br />
    <input class="title-medium" type="password" name="password" placeholder="Please Enter Your Password" value="">
    <br />
    <input class="title-medium" type="password" name="password2" placeholder="Double Confirm Your Password" value="">
    <br />
    <input class="title-large" type="submit" name="submit" value="Register">
</form>

<?php
require_once('../private/shared/public_footer.php');
mysqli_close($db);
?>