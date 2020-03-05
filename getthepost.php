<?php
include_once("includes/check_login.php");
include_once("classes/Posts.class.php");
$Posts = new Posts();
if(isset($_FILES["avatar"]) && !empty($_FILES["avatar"]["tmp_name"])){
    include_once("classes/Avatar.class.php");
    $myUser = new Avatar();
    echo $avatarResult = $myUser->uploadAvatar($_FILES["avatar"], $log_user);
    mysqli_close($cnctn);
    exit();
}
if(isset($_POST["crop_x"]) && isset($_POST["crop_y"]) && isset($_POST["crop_w"]) && isset($_POST["crop_h"]) && isset($_POST["img_url"])){
    include_once("classes/Avatar.class.php");
    $myUser = new Avatar();
    echo $myUser->cropAndSaveAvatar($cnctn, $_POST["img_url"], $log_user, $_POST["crop_x"], $_POST["crop_y"], $_POST["crop_w"], $_POST["crop_h"]);
    mysqli_close($cnctn);
    exit();
}
if(isset($_POST["imgurltocancel"])){
    include_once("classes/Avatar.class.php");
    $myUser = new Avatar();
    echo $myUser->cancelAvatarUploading($_POST["imgurltocancel"], $cnctn);
    mysqli_close($cnctn);
    exit();
}
if(isset($_POST["pst"]) && isset($_POST["user"])){
    $user = $_POST["user"];
    $full_post = "";
    $sql = "";
    switch($_POST["pst"]){
        case "drawings":
            $sql = "SELECT DISTINCT * from photos where user='$user' AND gallery='Drawings' ORDER BY uploaddate DESC";
            break;
        case "graphicdesigns":
            $sql = "SELECT DISTINCT * from photos where user='$user' AND gallery='Graphic Designs' ORDER BY uploaddate DESC";
            break;
        case "webdesigns":
            $sql = "SELECT DISTINCT * from photos where user='$user' AND gallery='Web Designs' ORDER BY uploaddate DESC";
            break;
        case "appdesigns":
            $sql = "SELECT DISTINCT * from photos where user='$user' AND gallery='App Designs' ORDER BY uploaddate DESC";
            break;
        case "others":
            $sql = "SELECT DISTINCT * from photos where user='$user' AND gallery='Others' ORDER BY uploaddate DESC";
            break;
        default:
            $sql = "SELECT DISTINCT * from photos where user='$user' ORDER BY uploaddate DESC";
    }
    if($query = mysqli_query($cnctn, $sql)){
        $numrows = mysqli_num_rows($query);
        if($numrows < 1){
            echo "<br>You've never posted";
        }
        else{
            echo "<div id='users-posts' class='posts-holder'>";
            include_once("classes/Posts.class.php");
            $Posts = new Posts();
            while($row = mysqli_fetch_assoc($query)){
                echo $Posts->getPosts($cnctn, $user_status, $row);
            }
            echo "</div>";
        }
    }
    else{
        echo "Failed to Query";
    }
    mysqli_close($cnctn);
    exit();
}
if(isset($_FILES["photoToUpload"]) && $_FILES["photoToUpload"]["tmp_name"] != "" && isset($_POST["gallery"]) && isset($_POST["posttitle"])){
    $gallery = preg_replace("'#[^a-z 0-9,]#i'", "", $_POST["gallery"]);
    $posttitle = mysqli_real_escape_string($cnctn, $_POST["posttitle"]);
    $description="";
    if(isset($_POST["description"]))
    {
        $description = mysqli_real_escape_string($cnctn, $_POST["description"]);
    }
    include_once("classes/PostControl.class.php");
    $postControl = new PostControl();
    $result = $postControl->uploadPost($_FILES["photoToUpload"], $gallery, $posttitle, $description, $cnctn, $log_user);
    if($result!="done"){
        mysqli_close($cnctn);
        header("Location: message?msg=".$result);
        exit();
    }
    else{
        mysqli_close($cnctn);
        header("location: user?u=$log_user");
        exit();
    }
}
if(isset($_POST["delete"]) && isset($_POST["id"])){
    $id= preg_replace("#[^0-9]#", "", $_POST["id"]);
    include_once("classes/PostControl.class.php");
    $postControl = new PostControl();
    echo $postControl->deletePost($id, $cnctn, $log_user);
    mysqli_close($cnctn);
    exit();
}
if(isset($_POST["like"]) && isset($_POST["id"])){
    $id= preg_replace("#[^0-9]#", "", $_POST["id"]);
    $likes = 0;
    $sql = "SELECT likes FROM photos WHERE id='$id'";
    $result = mysqli_query($cnctn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $likes = $row["likes"];
    }
    $likes++;
    $sql = "UPDATE photos SET likes='$likes' WHERE id='$id'";
    if(mysqli_query($cnctn, $sql)){
        echo "liked";
    }
    else{
        echo "failed";
    }
    mysqli_close($cnctn);
    exit();
}
else{
    echo "Unauthorised!";
    mysqli_close($cnctn);
    exit();
}
?>