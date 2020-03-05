<?php
include_once("includes/check_login.php");

$u = "";
$sex = "Male";
$userlevel = "";
$joindate = "";
$lastsession = "";

if(isset($_GET["u"])){
    $u = mysqli_real_escape_string($cnctn, $_GET["u"]);
}
else{
    mysqli_close($cnctn);
    if($user_status == true){
        header("Location: user?u=".$_SESSION["username"]);
        exit();
    }
    else{
        header("Location: login");
        exit();
    }
}

$sql = "SELECT * FROM users WHERE username='$u' AND activated='1' LIMIT 1";
$user_query = mysqli_query($cnctn, $sql);
$numrows = mysqli_num_rows($user_query);

if($numrows < 1)
{
    echo "That user does not exist or is not yet activated, Press back";
    mysqli_close($cnctn);
    exit();
}

$isOwner = "no";
if($u == $log_user && $user_status == true){
    $isOwner = "yes";
}

while($row = mysqli_fetch_assoc($user_query)){
    $first_name = $row["first"];
    $last_name = $row["last"];
    $profile_id = $row["id"];
    $gender = $row["gender"];
    $userlevel = $row["userlevel"];
    $avatar = $row["avatar"];
    $signup = $row["signup"];
    $lastlogin = $row["lastlogin"];
    $joindate = strftime("%b %d, %Y", strtotime($signup));
    $lastsession = strftime("%b %d, %Y", strtotime($lastlogin));
    $lasttime = strftime("%I:%M %p", strtotime($lastlogin));
    if($gender == "f"){
        $sex = "Female";
    }
}
$profile_pic = 'url(users/'.$u.'/'.$avatar.')';
if($avatar == NULL)
{
	$profile_pic = 'url("images/'.$sex.'.png")';
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
    <link rel="stylesheet" type="text/css" href="css/user.css" />
    <link rel="stylesheet" type="text/css" href="css/post.css" />
    <link rel="stylesheet" type="text/css" href="css/book.css" />
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <title><?php echo "$first_name $last_name"; ?> - Profile | Artistic Designing</title>
    <style>
        #profile-pic {
            height: 200px;
            width: 200px;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            background-color: white;
            <?php echo 'background-image: '.$profile_pic.';'; ?>
            border-radius: 50%;
            box-shadow: 4px 4px 12px rgba(0, 0, 0, 0.4);
            position: relative;
            display: inline-block;
            overflow: hidden;
            float: left;
            margin-left: 80px;
        }
    </style>
</head>
<body>
    <?php include_once 'header.php'; ?>
    <?php
    if($u == $log_user && $user_status === true){
        echo
        '<div id="notification"></div>
        <div class="dark-background" id="avatar-closer-background"></div>
        <div class="small-window" id="avatar-changer-window">
            <div class="small-window-content">
                <div class="window-header">Update your Avatar<input type="button" value="&times;" class="push-button close-small-window" id="close-avatar-changer"></div>
                <form class="photo-form" id="form-avatar" enctype="multipart/form-data" method="post">
                    <div class="file-drag-upload" id="drag-upload">
                        <div class="center-uploader">
                        <p>Drop your avatar here to upload</p>
                        <p>or</p>
                        <input type="file" id="pro-file" class="file-input" name="avatar" accept="image/*" onchange="fileuploaded(event)" required />
                        <input type="button" value="Upload" id="file-upload-button" onclick="_(\'pro-file\').click();" />
                        </div>
                    </div>
                    <div class="upload-status" id="avatar-status"></div>
                    <div class="cropping-tools" id="avatar-control-tools">
                        <button type="button" title="Rotate this image" onclick="rotateImage()"><img src="images/interaction/rotate.svg" /><br />Rotate</button>
                        <button type="button" title="Crop this image" onclick="showCrop()"><img src="images/interaction/crop.svg" /><br />Crop</button>
                        <button type="button" id="save-edit" onclick="postcroppedimage()" title="Save this image"><img src="images/interaction/save.svg" /><br />Save</button>
                        <button type="button" id="cancel-edit" onclick="cancelEditingAvatar()" title="Cancel saving this image"><img src="images/interaction/cancel.svg" /><br />Cancel</button>
                    </div>
                </form>
                <div id="avatar-loaded-info" class="loading-information">
                    <p id="file-name">Waiting for file...</p>
                    <div id="progressbar"><div id="progress"></div></div><input type="button" value="&times;" id="cancel-upload" alt="Cancel" title="Cancel upload" disabled>
                    <p id="loaded-percent">Waiting for file...</p>
                </div>
            </div>
        </div>

        <div class="dark-background" id="photo-poster-closer-background"></div>
        <div class="small-window" id="photo-post-window">
            <div class="small-window-content">
                <div class="window-header">Add a drawing<input type="button" value="&times;" class="push-button close-small-window" id="close-photo-adder"></div>
                <form class="photo-form" enctype="multipart/form-data" method="POST" action="getthepost.php">
                    <div class="file-drag-upload" id="drag-post-upload" style="margin-bottom: 8px;">
                        <div class="center-uploader">
                        <p>Drop Image here to upload</p>
                        <p>or</p>
                        <input type="file" id="post-file" class="file-input" name="photoToUpload" accept="image/*" required />
                        <input type="button" value="Upload" id="post-upload-button" onclick="_(\'post-file\').click();" />
                        </div>
                    </div>
                    <select name="gallery" id="select-category" required>
                        <option value="">Choose a gallery</option>
                        <option value="Drawings">Drawings</option>
                        <option value="Graphic Designs">Graphic Designs</option>
                        <option value="Web Designs">Web Designs</option>
                        <option value="App Designs">App Designs</option>
                        <option value="Others">Others</option>
                    </select>
                    <br />
                    <input type="text" name="posttitle" maxlength="20" title="20 characters maximum" autocomplete="off" placeholder="Title (0-20 words)" required />
                    <br />
                    <textarea maxlength="250" name="description" placeholder="Description"></textarea>
                    <br />
                    <input type="submit" value="Upload" class="push-button" id="post-uploader" onsubmit="postuploading(this)" />
                </form>
                <div id="post-loaded-info" class="loading-information">
                    <p id="post-file-name">Waiting for file...</p>
                    <div id="progressbar"><div id="progress"></div></div>
                    <input type="button" value="&times;" id="cancel-upload" alt="Cancel" title="Cancel upload" disabled>
                    <p id="loaded-percent">Waiting for file...</p>
                </div>
            </div>
        </div>

        <div class="add-photo-button push-button" id="add-post" alt="Add" title="Add new Post">+</div>';
    }
    ?>
    
    <div class="dark-background" id="post-showcase-closer-background"></div>
    <div class="small-window" id="post-showcase">
        <div class="small-window-content" id="small-post-showcase"></div>
    </div>
    
    <section id="profile-section">
        <div id="profile-pic" style="<?php if($gender == "f") echo 'background-image: '.$profile_pic.';'; ?>">
            <?php
            if($u == $log_user && $user_status == true){
                echo '<div class="non-focus"></div><div class="center-edit-button"><input type="button" value="Edit" id="profile-edit" class="push-button" /></div>';
            }
            ?>
        </div>
        <div id="user-details">
            <h2 id="name-of-user"><?php echo "$first_name $last_name"; ?></h2>
            <p>Gender: <?php echo $sex; ?></p>
            <p>User level: <?php if($userlevel == 'a') echo "100%"; else if($userlevel == 'b') echo "75%"; else if($userlevel == 'c') echo "50%"; else if($userlevel == 'd') echo "25%"; ?></p>
            <p>Join Date: <?php echo $joindate; ?></p>
            <p>Last seen on <?php echo "$lastsession at $lasttime"; ?></p>
            <?php
            if($u == $log_user && $user_status === true){
                echo '<br><a href="logout" style="color:#03353E; text-decoration:none;"><input type="submit" value="Logout" class="push-button" id="logout" /></a>';
            }
            ?> 
        </div>
        <?php
//        if($u != $log_user && $user_status !== true){
//            echo '<div id="friend-block">
//            <input type="button" class="push-button" value="Add Friend +" />
//            <input type="button" class="push-button" value="Block -" />
//            </div>';
//        }
        ?>
        <div class="clearfix"></div>
        <?php
            $sql = "SELECT DISTINCT * from photos where user='$u' ORDER BY uploaddate";
            include_once("classes/Posts.class.php");
            $Posts = new Posts();
            $imageNames = $Posts->getImagesOfAllPosts($cnctn, $sql);
            $title = $first_name.' '.$last_name.'\'s Artistic Book';
            $description = 'Since - '.strftime("%b %d, %Y", strtotime($joindate)).'.';
            if(is_array($imageNames) && sizeof($imageNames)>1){
                echo '<section id="book" class="book-section"><div class="container">';
                for($i=0;$i<sizeof($imageNames);$i++){
                    echo $Posts->getTheBook($title, $description, $imageNames[$i], sizeof($imageNames), $i);
                }
                echo '</div><button id="prevPage" onclick="turnLeft()">Prev</button> <button id="nextPage" onclick="turnRight()">Next</button><br/></section>';
            }
        ?>
        <div id="sub-menubar">
            <div><h2 id="all-posts" class="post-heading" onclick="showAllPosts(this,'all', '<?php echo $u; ?>')">All</h2><h2 id="drawing-posts" class="post-heading" onclick="showAllPosts(this,'drawings', '<?php echo $u; ?>')">Drawings</h2><h2 id="web-posts" class="post-heading" onclick="showAllPosts(this,'webdesigns', '<?php echo $u; ?>')">Web Designs</h2><h2 id="graphic-posts" class="post-heading" onclick="showAllPosts(this,'graphicdesigns', '<?php echo $u; ?>')">Graphic Designs</h2><h2 id="app-posts" class="post-heading" onclick="showAllPosts(this,'appdesigns', '<?php echo $u; ?>')">App Designs</h2><h2 id="other-posts" class="post-heading" onclick="showAllPosts(this,'others', '<?php echo $u; ?>')">Others</h2></div>
        </div>
        <section id="userposts-section">
            
        </section>
        <br />
    </section>
    <?php include_once 'footer.php'; ?>
    <script src="js/post.js"></script>
    <script>
    function _(x) {
        return document.getElementById(x);
    }

    function $(x) {
        return document.getElementsByClassName(x);
    }
        
    function showAllPosts(e, pst, user) {
        for (var i = 0; i < document.getElementsByClassName("post-heading-active").length; i++) {
            document.getElementsByClassName("post-heading-active")[i].classList.remove("post-heading-active");
        }
        var xhr = new XMLHttpRequest();
        var url = "getthepost.php";
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("userposts-section").innerHTML = xhr.responseText;
                e.classList.add("post-heading-active");
                useGrids(document.getElementById("users-posts"));
            }
        }
        xhr.send("pst=" + pst + "&user="+user);
        document.getElementById("userposts-section").innerHTML = "<div class='loader-holder'><div class='loader'><div class='outer-circle'><div class='middle-dot'></div><div class='clock-hand-short'></div><div class='clock-hand-long'></div></div><div class='loading-dots'><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span></div></div></div>";
    }
    
    function dragovereffect(event) {
        event.preventDefault();
        _("drag-upload").classList.add("uploader-dragged");
        return false;
    }

    function dragouteffect(event) {
        event.preventDefault();
        _("drag-upload").classList.remove("uploader-dragged");
        return false;
    }

    function filedropped(event) {
        event.preventDefault();
        _("drag-upload").classList.remove("uploader-dragged");
        var file2upload = event.dataTransfer.files;
        changeavatar(file2upload);
    }
        
    showAllPosts(document.getElementById("all-posts"), "all", "<?php echo $u; ?>");
        
    if ("<?php echo $isOwner; ?>" == "yes") {
        _("drag-upload").addEventListener("dragover", dragovereffect);
        _("drag-upload").addEventListener("dragleave", dragouteffect);
        _("drag-upload").addEventListener("drop", filedropped);
        _("profile-edit").addEventListener("click", ()=>{
            showSmallWindow("avatar-changer-window", "avatar-closer-background");
        });
        _("close-avatar-changer").addEventListener("click", ()=>{
            closeSmallWindow("avatar-changer-window", "avatar-closer-background");
        });
        _("add-post").addEventListener("click", ()=>{
            showSmallWindow("photo-post-window", "photo-poster-closer-background");
        });
        _("close-photo-adder").addEventListener("click", ()=>{
            closeSmallWindow("photo-post-window", "photo-poster-closer-background");
        });
        _("avatar-closer-background").addEventListener("click", ()=>{
            closeSmallWindow("avatar-changer-window", "avatar-closer-background");
        });
        _("photo-poster-closer-background").addEventListener("click", ()=>{
            closeSmallWindow("photo-post-window", "photo-poster-closer-background");
        });
    }
    </script>
    <script src="js/script.js"></script>
    <script src="js/user.js"></script>
    <script src="js/book.js"></script>
</body>
</html>