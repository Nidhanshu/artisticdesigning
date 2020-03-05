<?php
if(isset($_GET["id"]) && isset($_GET["u"]) && isset($_GET["e"]) && isset($_GET["p"])){
    include_once("includes/database_link.php");
    $id = preg_replace("#[^0-9]#i", "", $_GET["id"]);
    $u = preg_replace("#[^a-z0-9]#i", "", $_GET["u"]);
    $e = mysqli_real_escape_string($cnctn, $_GET["e"]);
    $p = mysqli_real_escape_string($cnctn, $_GET["p"]);
    
    if(empty($id) || strlen($u) < 3 || strlen($u) > 20 || strlen($e) < 5 || empty($p)){
        $error = "USER ID: ".$id." USERNAME: ".$u." EMAIL: ".$e;
        mail("nidhanshu@artisticdesigning.com", "WRONG GET VARIABLES RECEIVED!", $error);
        mysqli_close($cnctn);
        header("Location: message?msg=string_lengh_issues");
        exit();
    }
    else{
        $sql = "SELECT * FROM users WHERE id='$id' AND username='$u' AND email='$e' AND password='$p' LIMIT 1";
        $query = mysqli_query($cnctn, $sql);
        $numrows = mysqli_num_rows($query);
        
        if($numrows == 0){
            $error = "USER ID: ".$id." USERNAME: ".$un." EMAIL: ".$em;
            mail("nidhanshu@artisticdesigning.com", "HACK ATTEMPTS !", $error);
            mysqli_close($cnctn);
            header("Location: message?msg=Your credentials are not matching anything in our system");
            exit();
        }
        if($numrows == 1){
            $sql = "UPDATE users SET activated='1' WHERE id='$id' LIMIT 1";
            $query = mysqli_query($cnctn, $sql);
            
            $sql = "SELECT * FROM users WHERE id='$id' AND activated = '1' LIMIT 1";
            $query = mysqli_query($cnctn, $sql);
            $numrows = mysqli_num_rows($query);
            
            if($numrows == 0){
                $error = "USER ID: ".$id." USERNAME: ".$un." EMAIL: ".$em;
                mail("nidhanshu@artisticdesigning.com", "ACTIVATION NOT SUCCESSFULLY SWITCHED TO 1!", $error);
                mysqli_close($cnctn);
                header("Location: message?msg=activation_failed");
                exit();
            }
            else if($numrows == 1){
                mysqli_close($cnctn);
                header("Location: message?msg=activation_success");
                exit();
            }
        }
    }
}
else{
    $error = "USER ID: ".$id." USERNAME: ".$un." EMAIL: ".$em;
    mail("nidhanshu@artisticdesigning.com", "GET VARIABLES NOT FOUND!", $error);
    header("Location: message?msg=activation_failed");
    exit();
}
?>