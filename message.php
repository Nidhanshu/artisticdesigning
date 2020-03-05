<?php
include_once "includes/check_login.php";
$message = "";
if(isset($_GET["msg"])){
    $msg = preg_replace('#[^a-z 0-9.:_()]#i', '', $_GET['msg']);
}
else{
    mysqli_close($cnctn);
    header("Location: index");
    exit();
}
if($msg == "activation_failure"){
	$message = '<h2>Activation Error</h2> Sorry there seems to have been an issue activating your account at this time. We have already notified ourselves of this issue and we will contact you via email when we have identified the issue.';
}else if($msg == "activation_success"){
	$message = '<h2>Activation Success</h2> Your account is now activated. <a style="color: dodgerblue;" href="login">Click here to log in</a>';
}else {
	$message = $msg;
}
?>
<!DOCTYPE>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="utf-8" />
    <meta name="description" content="Free to use Artworks, Vectors, Designs, Material Designs, Website Designs, Application Designs, Logos, Brochures, Invitation Cards &amp; much more." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="js/script.js" async></script>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <title>Message | Artistic Designing</title>
<style>
#activation-section
{
    height: auto;
    width: 100%;
    background-color: aliceblue;
    position: relative;
    overflow: auto;
    margin-bottom: 50vh;
    z-index: 1;
    padding: 20vh 5% 5vh 5%;
    -webkit-box-sizing:border-box;
    -moz-box-sizing:border-box;
    box-sizing:border-box;
    color:black;
    text-shadow:1px 1px 2px rgba(0,0,0,0.5);
    font-size: 20px;
    font-family: calibri;
}
    
@media only screen and (max-width: 768px)
{
    #activation-section
    {
        height: auto;
        margin-bottom: 0;
        padding: 12vh 5% 5vh 5%;
    }
}
</style>
</head>
<body>
<?php include_once("header.php"); ?>
<div id="activation-section"><?php echo $message; ?></div>
<?php include_once("footer.php"); ?>
</body>
</html>