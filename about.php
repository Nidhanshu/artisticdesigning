<?php
include_once("includes/check_login.php");
if(isset($_POST["fn"]) && isset($_POST["ln"]) && isset($_POST["e"]) && isset($_POST["m"])){
    $n = mysqli_real_escape_string($cnctn, $_POST["fn"]." ".$_POST["ln"]);
    $e = mysqli_real_escape_string($cnctn, $_POST["e"]);
    $m = mysqli_real_escape_string($cnctn, nl2br($_POST["m"]));
    mysqli_close($cnctn);
    $to = "nidhanshusharma171@gmail.com";
    $from = $e;
    $subject = "Contact form message";
    $message = "<strong>Name: </strong>$n<br /><strong>Email: </strong>$e<br /><p>$m</p>";
    $headers = "From: $from\n";
    $headers.="MIME-Version: 1.0\n";
    $headers.="Content-type: text/html; charset=iso-8859-1\n";
    if(mail($to, $subject, $message, $headers)){
        echo "Success";
    }
    else
        echo "Server failed to send message. Please try again.";
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
    <title>About | Artistic Designing</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
</head>
<body>
    <?php include_once("header.php"); ?>
    <section id="slider-section">
        <button class="arrow-left" onclick="prevSlide()">&#10094;</button>
        <button class="arrow-right" onclick="nextSlide()">&#10095;</button>
        <div class="dots-container">
            <span class="dot active-slide" onclick="dotSlider(0)"></span>
            <span class="dot" onclick="dotSlider(1)"></span>    
            <span class="dot" onclick="dotSlider(2)"></span>
            <span class="dot" onclick="dotSlider(3)"></span>
        </div>
        <figure id="slider-fig">
            <div class="slide slide1">
                <div class="slide-content">
                    <h3>You can upload &amp; share the</h3>
                    <h1>Artwork</h1>
                    <h5>which everyone can use for free</h5>
                    <br />
                    <a href="signup" class="push-button" title="Sign up now! & start creating">Sign up &#10095;</a>
                    <p>Sign up to start sharing</p>
                </div>
            </div>
            <div class="slide slide2">
                <div class="slide-content">
                    <h3>You can upload &amp; share the</h3>
                    <h1>Graphics</h1>
                    <h5>which everyone can use for free</h5>
                    <br />
                    <a href="signup" class="push-button" title="Sign up now! & start creating">Sign up &#10095;</a>
                    <p>Sign up to start sharing</p>
                </div>
            </div>
            <div class="slide slide3">
                <div class="slide-content">
                    <h3>You can upload &amp; share the</h3>
                    <h1>Web Designs</h1>
                    <h5>which everyone can use for free</h5>
                    <br />
                    <a href="signup" class="push-button" title="Sign up now! & start creating">Sign up &#10095;</a>
                    <p>Sign up to start sharing</p>
                </div>
            </div>
            <div class="slide slide4">
                <div class="slide-content">
                    <h3>You can upload &amp; share the</h3>
                    <h1>App Designs</h1>
                    <h5>which everyone can use for free</h5>
                    <br />
                    <a href="signup" class="push-button" title="Sign up now! & start creating">Sign up &#10095;</a>
                    <p>Sign up to start sharing</p>
                </div>
            </div>
            <div class="clearfix"></div>
        </figure>
    </section>
    <section id="facilities-section">
        <h1>Free to use:</h1>
        <div class="colm">
            <img src="images/graphic.svg" alt="Graphics icon" height="100" />
            <h3>Graphics</h3>
            <p>You can Explore, Download or Upload the Illustrations.</p>
        </div>
        <div class="colm">
            <img src="images/art.svg" alt="Graphics icon" height="100" />
            <h3>Artwork</h3>
            <p>You can Explore, Download or Upload the Art.</p>
        </div>
        <div class="colm">
            <img src="images/web.svg" alt="Graphics icon" height="100" />
            <h3>Web Designs</h3>
            <p>You can Explore, Download or Upload the Web designs.</p>
        </div>
        <div class="colm">
            <img src="images/app.svg" alt="Graphics icon" height="100" />
            <h3>App Designs</h3>
            <p>You can Explore, Download or Upload the Mobile App Designs.</p>
        </div>
        <div class="clearfix"></div>
        <hr />
    </section>
    <section id="members-section">
        <div class="members-container">
            <div class="member-pics"></div>
            <div class="member-pics"></div>
            <div class="member-pics"></div>
            <div class="member-pics"></div>
            <div class="member-pics"></div>
        </div>
        <h4><strong><span><?php 
            $sql = "SELECT COUNT(*) AS tot FROM `users` WHERE activated='1'";
            if($query = mysqli_query($cnctn, $sql)){
                $noofusers = mysqli_fetch_assoc($query);
                if($noofusers["tot"]>1){
                    echo $noofusers["tot"];
                }
                else{
                    echo "(Error: No users found)";
                }
            }
            else{
                echo "(Error: Query Failed)";   
            }
            ?>+</span> Amazing Users</strong><br /><small>already joined the community</small></h4>
        <br />
        <div class="posts-container">
            <div class="post-pics"></div>
            <div class="post-pics"></div>
            <div class="post-pics"></div>
            <div class="post-pics"></div>
            <div class="post-pics"></div>
        </div>
        <h4><strong><span><?php 
            $sql = "SELECT COUNT(*) AS total FROM `photos`";
            if($query = mysqli_query($cnctn, $sql)){
                    $noofposts = mysqli_fetch_assoc($query);
                    if($noofposts["total"]>1){
                        echo $noofposts["total"];
                    }
                    else{
                        echo "(Error: No Post found)";
                    }
            }
            else{
                echo "(Error: Query Failed)";
            }
            ?>+</span> Cool posts</strong><br /><small>by our community members</small></h4>
        <br />
        <hr />
    </section>
    <section id="about-section">
        <div class="periscope"></div>
        <h2 class="heading">About us</h2>
        <p>Over the years we have grown in all aspects and continue to grow every day but our goals have remained the same.
        Have fun while working with the best technology at hand. Design and create the finest product we can.
        Compete with the top in the industry. Learn from the best. Focus on the essential.
        Cultivate openness and respect in all communication.</p>
    </section>
    <section id="contact-section">
        <figure></figure>
        <form class="formy" id="c-us" onSubmit="contactUs(); return false;">
            <h1>Contact us:</h1>
            <div class="input-holder"><input type="text" name="" id="c-fname" formy-input="small" onblur="checkval(this)" required /><label for="c-fname">First Name</label><input type="text" name="" id="c-lname" formy-input="small" required onblur="checkval(this)" /><label for="c-lname">Last Name</label></div>
            <div class="input-holder"><input type="email" name="" id="c-email" required onblur="checkval(this)" /><label for="c-email">Email</label></div>
            <div class="input-holder"><textarea name="" rows="5" id="c-message" onblur="checkval(this)" required></textarea><label>Message</label></div>
            <input type="submit" value="Send" id="c-send" class="push-button" />
        </form>
    </section>
    <?php include_once("footer.php"); ?>
    <script src="js/script.js"></script>
    <script src="js/index.js"></script>
</body>
</html>