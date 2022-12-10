<?php
// show user profiles
    session_start();
    require_once("../private/database.php");
    require_once("../private/included_functions.php");
    require_SSL();

    //checks if user is logged in otherwise redirect to login page
    if(!isset($_SESSION['valid_user'])) {
        $_SESSION['callback_url'] = 'showwatchlist.php';
        redirect_to('login.php');
    } 

    $email = $_SESSION['valid_user'];

    $selectQuery = "SELECT lname, fname ";
    $selectQuery .= "FROM users ";
    $selectQuery .= "WHERE email='$email'";
    $result = $db->query($selectQuery);

    // if changes are made and applied
    // then input validation is made before the changes are stored in the database
    if (isset($_POST['submit'])) {
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
        } else if (!$password) {
            $message = "Missing information.";
        } else {
            $pw_encrypted = password_hash($password, PASSWORD_DEFAULT);
    
            $query = "UPDATE users SET password=(?) WHERE email='$email'";
    
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, "s", $pw_encrypted);
            mysqli_stmt_execute($stmt);
            $message = "Successfully changed password.";
        }
    } else {
        $password = "";
        $password2 = "";
    }

    include_once('../private/shared/public_header.php');

    // fetches the last name and first name from database and display them
    while ($row = $result->fetch_assoc()) {

        $lname = $row['lname'];
        $fname = $row['fname'];
    };

    echo '<div class= "user">';
    echo "<h2 class=\"display-medium\">Welcome, " . $fname . " " . $lname . "</h2>";
    if (!empty($message)) echo "<p class=\"message\">" . $message . '</p>';
    echo "<p class=\"headline-medium\">Registration Details</p>";
    echo '<section class = "userinfo">';
    echo "<p class=\"body-large\">Email: $email</p>";
    echo "<p class=\"body-large\">First Name: $fname</p>";
    echo "<p class=\"body-large\">Lirst Name: $lname</p>";

    echo '<section class="changepassbtn">';

    // checks if edit option is submitted
    // if not then edit button will be displayed
    if(!isset($_POST['edit'])){
        echo "<form action='user.php' method='post'>";
        echo "<input class='title-meidum' type='submit' name='edit' value='Edit Password'>";
        echo "</form>";
    }
    echo '</section></section>';

    // if edit option is selected then the option to apply the changes is shown
    if(isset($_POST['edit'])){
        echo '<form class="pw" action="user.php" method="post">
        <input class="body-large" type="password" name="password" placeholder="Please Enter Your New Password" value="">
        <br />
        <input class="body-large" type="password" name="password2" placeholder="Double Confirm Your New Password" value="">
        <br />
        <input class="title-meidum" type="submit" name="submit" value="Apply">
        </form>';
    }

    echo '</div>';

    require_once('../private/shared/public_footer.php');

    $result->free_result();
    $db->close();
?>