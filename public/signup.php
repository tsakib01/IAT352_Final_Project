<?php
// <!-- Allow users to register using a form with inputs for email, fname, lname, password, confirm password   -->
include('../private/included_functions.php');
require_once("../private/database.php");
require_SSL();

$selectQuery = "SELECT email FROM users";
$result = $db->query($selectQuery);

// validates all inputs after user submits the information
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

    // checks if the user already exists by email 
    // if adds the user to the database and redirects to login.php page
    // if not then shows an appropriate based on the inputs submitted
    while ($row = $result->fetch_row()){
        if($email == $row[0]){
            $repeat = 1;
        } else{
            $repeat = 0;
        }
    };
    if($repeat == 1){
        $message = "This email has been registered.";
    } else if ($password != $password2) {
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
    <input class="title-medium" name="fname" type="text" placeholder="Please Enter Your First Name" value="<?php $fname ?>" required>
    <br />
    <input class="title-medium" type="text" name="lname" placeholder="Please Enter Your Last Name" value="<?php $lname ?>" required>
    <br />
    <input class="title-medium" type="email" name="email" placeholder="Please Enter Your Email Adress" value="<?php $email ?>" required>
    <br />
    <input class="title-medium" type="password" name="password" placeholder="Please Enter Your Password" value="" required>
    <br />
    <input class="title-medium" type="password" name="password2" placeholder="Double Confirm Your Password" value="" required>
    <br />
    <input class="title-large" type="submit" name="submit" value="Register">
</form>

<?php
require_once('../private/shared/public_footer.php');
$result->free_result();
mysqli_close($db);
?>