<?php
include_once("includes/check_login.php");

if(isset($_SESSION["user"])){
    mysqli_close($cnctn);
    header("Location: message?msg=You are already logged in");
    exit();
}

include_once("classes/Signup.class.php");
$signup = new Signup($cnctn);
if(isset($_POST["usernamecheck"])){
    $username = preg_replace('#[^a-z0-9]#i', '', $_POST["usernamecheck"]);
    echo $signup->checkIfUsernameExist($username, "users", "username");
    mysqli_close($cnctn);
    exit();
}
if(isset($_POST["user"])){
    $first = $_POST["first"];
    $last = $_POST["last"];
    $email = $_POST["email"];
    $username = preg_replace('#[^a-z0-9]#i', '', $_POST["user"]);
    $password = $_POST["password"];
    $gender = $_POST["gender"];
    $ip = preg_replace("#[^0-9.]#", "", getenv('REMOTE_ADDR'));
    $data = array(
        "first"=>$first,
        "last"=>$last,
        "gender"=>$gender,
        "ip"=>$ip,
        "signup"=>time(),
        "lastlogin"=>time(),
        "notescheck"=>time()
    );
    echo $signup->signup("users", $username, "username", $email, "email", $password, "password", $data, true);
    mysqli_close($cnctn);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="utf-8" />
    <meta name="description" content="Free to use Artworks, Vectors, Designs, Material Designs, Website Designs, Application Designs, Logos, Brochures, Invitation Cards &amp; much more." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/signup.css" />
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <title>Sign Up page | Artistic Designing</title>
</head>
<body>
<?php include_once 'header.php'; ?>
<section id="signup-section">
    <form id="signup-form">
        <h1>Sign up</h1> <a href="login" id="form-switch" class="button">Login</a><div class="clearfix"></div>
        <div id="signup-name">
            <div class="signup-input-div">
                <input class="signup-input" type="text" name="firstname"  id="firstname" onBlur="signupPlaceholderCheck(event)" oninput="signupPlaceholderCheck(event)" required>
                <label class="signup-placeholder" for="firstname">First Name</label>
            </div>
            <div class="signup-input-div">
                <input class="signup-input" type="text" name="lastname" id="lastname" onBlur="signupPlaceholderCheck(event)" oninput="signupPlaceholderCheck(event)" required>
                <label class="signup-placeholder" for="lastname">Last Name</label>
            </div>
        </div>
        <div class="signup-input-div">
            <input class="signup-input" type="email" id="email"  name="email" maxlength="88" onBlur="signupPlaceholderCheck(event)" oninput="signupPlaceholderCheck(event)" required>
            <label class="signup-placeholder" for="email">Your Email</label>
        </div>
        <div class="signup-input-div">
            <span class="popup-box"></span>
            <input class="signup-input" type="text" id="username" name="username" maxlength="20" pattern=".{3,20}" title="3 characters minimum" autocomplete="off" onBlur="signupPlaceholderCheck(event)" oninput="signupPlaceholderCheck(event)" required>
            <label class="signup-placeholder" for="username">Username</label>
        </div>
        <div class="signup-input-div">
            <input class="signup-input" type="password" name="password" id="password" onBlur="signupPlaceholderCheck(event)" oninput="signupPlaceholderCheck(event)" required>
            <label class="signup-placeholder" for="password">Password</label>
        </div>
        <div class="signup-input-div">
            <span class="popup-box"></span>
            <input class="signup-input" type="password" name="confirm-password" id="confirm-password" onBlur="signupPlaceholderCheck(event)" oninput="signupPlaceholderCheck(event)" required>
            <label class="signup-placeholder" for="confirm-password">Confirm your password</label>
        </div>
        <select name="gender" id="gender" required>
            <option value="">Select Gender</option>
            <option value="m">Male</option>
            <option value="f">Female</option>
            <option value="o">Other</option>
        </select>
        <div id="main-status"></div>
        <input type="submit" value="Sign Up" class="button" id="submit-button">
    </form>
</section>
<?php include_once 'footer.php'; ?>
<script src="js/script.js"></script>
<script src="js/signup.js"></script>
</body>
</html>