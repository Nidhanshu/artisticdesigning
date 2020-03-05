<?php
include_once("includes/check_login.php");
if($user_status == true){
    mysqli_close($cnctn);
	header("Location: user?u=".$_SESSION["user"]);
    exit();
}
?>
<?php
if(isset($_POST["e"])){
    $e = mysqli_real_escape_string($cnctn, $_POST["e"]);
    $sql = "SELECT id, username FROM users WHERE email='$e' AND activated='1' LIMIT 1";
    $query = mysqli_query($cnctn, $sql);
    $numrows = mysqli_num_rows($query);
    if($numrows > 0){
        while($row = mysqli_fetch_assoc($query)){
            $id = $row["id"];
            $u = $row["username"];
        }
        $emailcut = substr($e, 0, 4);
        $randnum = rand(10000,99999);
        $temppass = "$emailcut$randnum";
        $hashedtemppass = password_hash($temppass, PASSWORD_DEFAULT);
        $sql = "UPDATE useroptions SET temp_pass='$hashedtemppass' WHERE username='$u' LIMIT 1";
        $query = mysqli_query($cnctn, $sql);
        
        $to = "$e";
        $from = "autoresponder@artisticdesigning.com";
        $headers = "From: $from\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
        $subject = "Artistic Designing Temporary Password";
        $message = '<h2>Hello '.$u.'</h2><p>This is an automated message from Artistic Designing. If you did not recently initiate the Forgot Password process, please disregard this email.</p><p>You indicated that you forgot your login password. We can generate a temporary password for you to log in with, then once logged in you can change your password to anything you like.</p><p>After you click the link below your password to login will be:<br /><b>'.$temppass.'</b></p><p><a href="http://www.artisticdesigning.com/forgot_password?u='.$u.'&p='.$hashedtemppass.'">Click here now to apply the temporary password shown below to your account</a></p><p>If you do not click the link in this email, no changes will be made to your account. In order to set your login password to the temporary password you must click the link above.</p>';
        
        if(mail($to,$subject,$message,$headers)){
            echo "success";
        }
        else{
            $delete = "UPDATE useroptions SET temp_pass = NULL WHERE username='$u'";
            if(!$query = mysqli_query($cnctn, $delete))
            {
                echo "Error deleting record!";
            }
            echo "mail_failed";
        }
    }
    else{
        echo "not_exist";
    }
    mysqli_close($cnctn);
    exit();
}

if(isset($_GET["u"]) && isset($_GET["p"])){
    $u = preg_replace("#[^a-z0-9]#i","",$_GET["u"]);
    $tp = mysqli_real_escape_string($cnctn, $_GET["p"]);
    
    if(strlen($tp) < 20){
        mysqli_close($cnctn);
        exit();
    }
    $sql = "SELECT * from useroptions WHERE username='$u' AND temp_pass='$tp' LIMIT 1";
    $query = mysqli_query($cnctn, $sql);
    $numrows = mysqli_num_rows($query);
    if($numrows == 0){
        mysqli_close($cnctn);
        header("Location: message?msg=No user found in our system with that email address. We can not proceed. You can contact us if you are getting this error again and again.");
        exit();
    }
    else{
        $row = mysqli_fetch_assoc($query);
        $id = $row["id"];
        $sql = "UPDATE users SET password='$tp' WHERE id='$id' AND username='$u' LIMIT 1";
        $query=mysqli_query($cnctn, $sql);

        $sql = "UPDATE useroptions SET temp_pass = NULL WHERE username='$u' LIMIT 1";
        $query=mysqli_query($cnctn, $sql);
        mysqli_close($cnctn);
        header("Location: login");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="utf-8" />
    <meta name="description" content="Free to use Artworks, Vectors, Designs, Material Designs, Website Designs, Application Designs, Logos, Brochures, Invitation Cards &amp; much more." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="js/script.js" async></script>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <title>Temporary password setup | Artistic Designing</title>
<style>
#forgot-section
{
	height: auto;
	width: 100%;
	background-color: #C1403D;
	position: relative;
	overflow: hidden;
	z-index: 1;
    padding: 160px 0 80px;
}

#forgot-section #forgot-form
{
    height: auto;
	width: 70%;
	position: relative;
    margin: 0 auto;
	border-radius: 10px;
	background-color: deepskyblue;
	-webkit-box-shadow: 6px 6px 15px rgba(0,0,0,0.4);
	box-shadow: 6px 6px 15px rgba(0,0,0,0.4);
	padding: 60px;
	color: white;
	font-family: calibri;
    font-size: 18px;
}

#forgot-form input[type=submit], #forgot-form input[type=button]
{
	background-color: #03353E;
	color: white;
	border: none;
	border-radius: 30px;
    padding: 10px 20px;
	-webkit-box-shadow: 2px 2px 10px rgba(0,0,0,0.2);
	box-shadow: 2px 2px 10px rgba(0,0,0,0.5);
	font-family: calibri;
    transition: 0.3s ease-in;
}
#forgot-form input[type=submit]:focus
{
	transform: scale(0.9);
    background-color: #085563;
}
#forgot-form h1
{
	color: #03353E;
    font-size: 22px;
    text-decoration: underline;
    font-family: my_font;
    margin: 0 0 30px 0;
    padding: 0;
    display: inline-block;
}

#forgot-form h3
{
	color: #0d4c56;
	text-decoration: none;
    font-size: 16px;
    text-decoration: underline;
    font-family: my_font;
    margin: 0;
    padding: 0;
    display: inline-block;
}
    
#forgot-form > .forgot-input-div
{
	position: relative;
	width:100%;
	height: 36px;
    margin: 30px 0px;
}

#forgot-form > .forgot-input-div .forgot-input
{
	position: absolute;
	border: none;
	border-bottom: 1px solid #0B889F;
	background-color: transparent;
	width: 100%;
	height: 100%;
	color: #03353E;
	font-family: calibri;
	padding: 8px;
	font-size: 18px;
	z-index: 1;
	-webkit-transition: 0.3s;
	transition: 0.3s;
}

#forgot-form > .forgot-input-div .forgot-input:focus
{
	outline: none;
	border-bottom: 1px solid #03353E;
    box-shadow: 0 1px 0 0 #03353E;
}

#forgot-form > .forgot-input-div label
{
	position: absolute;
	left: 8px;
	top: 50%;
	-webkit-transform: translateY(-50%);
	-ms-transform: translateY(-50%);
	transform: translateY(-50%);
	font-family: calibri;
	font-size: 18px;
	color: #0B889F;
    pointer-events: none;
	z-index: 0;
	white-space: nowrap;
	-webkit-transition:0.4s;
	transition:0.4s;
}

#forgot-status
{
    display: none;
    color: white;
    font-size: 18px;
    padding: 10px 20px;
    background: #C1403D;
    border-radius: 10px;
    position: relative;
    -webkit-animation: status 0.4s ease-in-out both;
    animation: status 0.4s ease-in-out both;
    margin-bottom: 30px;
    -webkit-box-shadow: 2px 2px 4px rgba(0,0,0,0.2);
	box-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}
    
@-webkit-keyframes status
{
    0%{-webkit-transform: scale(0);transform: scale(0);}
    75%{-webkit-transform: scale(1.2);transform: scale(1.2);}
    100%{-webkit-transform: scale(1);transform: scale(1);}
}

@keyframes status
{
    0%{-webkit-transform: scale(0);transform: scale(0);}
    75%{-webkit-transform: scale(1.2);transform: scale(1.2);}
    100%{-webkit-transform: scale(1);transform: scale(1);}
}
#forgot-form .forgot-input.active-input ~ label{
    left: 3px;
    top: -12px;
    transform: translateY(0%);
    color: #03353E;
    font-size: 12px;
}
@media only screen and (max-width: 768px)
{
    #forgot-section
    {
        padding: 120px 0 50px;
    }
    #forgot-section #forgot-form
    {
        width: 90%;
        padding: 50px 25px;
        font-size: 16px;
    }
    #forgot-form h1
    {
        font-size: 20px;
    }
    #forgot-form h3
    {
        font-size: 14px;
    }
    #forgot-form > .forgot-input-div
    {
        margin-bottom: 30px;
    }
    #forgot-form input[type=submit]
    {
        font-size: 16px;
        font-weight: 500;
    }
    #forgot-form .forgot-input-div .forgot-input
    {
        font-size: 16px;
    }
    #forgot-status
    {
        font-size: 16px;
    }
    #forgot-form .forgot-input.active-input ~ label{
        font-size: 10px;
    }
}
</style>
</head>
<body>
<?php include_once 'header.php'; ?>
<section id="forgot-section">
        <form id="forgot-form">
            <h1>Generate a temporary login password</h1>
            <br />
            <h3 id="steps">Step-1</h3>
            <div class="forgot-input-div">
                <input class="forgot-input" type="text" id="forgot-email" name="username" onBlur="forgotPlaceholderCheck(event)" oninput="forgotPlaceholderCheck(event)" required>
                <label class="login-placeholder" for="forgot-email">Enter your Email address</label>
            </div>
            <div id="forgot-status"></div>
            <input type="submit" value="Proceed" class="button" name="submit" id="forgot-submit">
        </form>
</section>
<?php include_once 'footer.php'; ?>
<script>
document.getElementById("forgot-form").addEventListener("submit", function(event){event.preventDefault(); forgot(); return false;});

function forgot()
{
    var ajax=new XMLHttpRequest();
    var url = "forgot_password.php";

    var e = _("forgot-email").value;
    
    if(e == "")
    {
        _("forgot-status").style.display="block";
        _("forgot-status").innerHTML="Type in your email address";
    }
    else
    {
        ajax.open("POST", url, true);
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.onreadystatechange = 
            function()
            {
                if(ajax.readyState == 4 && ajax.status == 200)
                    {
                        var data = ajax.responseText;
                        if(data == "success")
                        {
                            _("steps").innerHTML="Step-2";
                            _("forgot-form").innerHTML="A temporary password has been created and sent to your email address, Please check your email address in a moment.";
                        }
                        else if(data == "mail_failed")
                        {
                            _("forgot-submit").style.display="inline";
                            _("forgot-status").style.display="block";
                            _("forgot-status").innerHTML="Mail failed to execute. Please try again.";
                        }
                        else if(data == "not_exist")
                        {
                            _("forgot-submit").style.display="inline";
                            _("forgot-status").style.display="block";
                            _("forgot-status").innerHTML='<p style="color:#03353E;">Sorry that email address is not in our system. Check if you mistyped the email address and try again.</p>';
                        }
                        else
                        {
                            _("forgot-submit").style.display="inline";
                            _("forgot-status").style.display="block";
                            _("forgot-status").innerHTML = ajax.responseText;
                        }
                    }
            }
        _("forgot-status").style.display="block";
        _("forgot-submit").style.display="none";
        _("forgot-status").innerHTML="Please wait...";
        ajax.send("e="+e);
    }
}
    
function forgotPlaceholderCheck(e)
{
    var inp = e.target;
    if(inp.value == "")
        inp.classList.remove("active-input");
    else
        inp.classList.add("active-input");
}
</script>
</body>
</html>