<?php
include_once("includes/check_login.php");
if($user_status == true){
    mysqli_close($cnctn);
	header("Location: user?u=".$_SESSION["user"]);
    exit();
}
?>
<?php
if(isset($_POST["u"]) && isset($_POST["p"])){
    $data = array(
        "username"=>$_POST["u"],
        "email"=>$_POST["u"],
        "password"=>$_POST["p"]
    );
    $ip = preg_replace("#[^0-9.]#", "", getenv("REMOTE_ADDR"));
    $updationData = array(
        "ip"=>$ip,
        "lastlogin"=>time()
    );
    include_once("classes/Login.class.php");
    $helper = new Login($cnctn);
    echo $helper->loginAndUpdate("users", $data, $updationData, true, true, true);
    mysqli_close($cnctn);
    exit();
}
mysqli_close($cnctn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="utf-8" />
    <meta name="description" content="Free to use Artworks, Vectors, Designs, Material Designs, Website Designs, Application Designs, Logos, Brochures, Invitation Cards &amp; much more." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/login.css" />
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <title>Login page | Artistic Designing</title>
</head>
<body>
<?php include_once 'header.php'; ?>
<section id="login-section">
    <form id="login-form">
        <h1>Login</h1>
        <a href="signup" id="form-switch" class="button">Sign up</a>
        <div class="clearfix"></div>
        <div class="login-input-div">
            <input class="login-input" type="text" id="login-username" name="username" onBlur="loginPlaceholderCheck(event)" oninput="loginPlaceholderCheck(event)" required />
            <label class="login-placeholder" for="login-username">Enter your Username or E-mail</label>
        </div>
        <div class="login-input-div">
            <input class="login-input" type="password" id="login-password" name="password" onBlur="loginPlaceholderCheck(event)" oninput="loginPlaceholderCheck(event)" required />
            <label class="login-placeholder" for="login-password">Enter your Password</label>
        </div>
        <a href="forgot_password" style="font-size:16px; color:#222; text-decoration:underline;">Forgot password?</a>
        <div id="login-status"></div>
        <br />
        <input type="submit" value="Login" class="button" name="submit" id="login-submit">
    </form>
</section>
<?php include_once 'footer.php'; ?>
<script src="js/script.js"></script>
<script src="js/login.js"></script>
</body>
</html>