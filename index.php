<?php
include_once("includes/check_login.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="utf-8" />
    <meta name="description" content="Free to use Artworks, Vectors, Designs, Material Designs, Website Designs, Application Designs, Logos, Brochures, Invitation Cards & much more." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Artistic Designing</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/post.css" />
    <link rel="stylesheet" type="text/css" href="css/book.css" />
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <style>
        body{
            margin:0;
        }
        *{
            box-sizing: border-box;
        }
        section#top-posts{
            padding: 120px 0 50px 0;
            background-color: #ffe082;
            text-align: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            animation: slidee 5s ease-in-out infinite reverse both;
        }
        @keyframes slidee{
            0%{
                background-image: url('images/colorful-1.jpg');
            }
            33%{
                background-image: url('images/colorful-2.jpg');
            }
            66%{
                background-image: url('images/colorful-3.jpg');
            }
            100%{
                background-image: url('images/asiimov.jpg');
            }
        }
        .loader-holder{
            margin: 20px 0;
        }
        section{
            background-color: #fff;
        }
        section > h1{
            margin: 0;
            font-family: calibri;
            color: #fff;
        }
        section > p{
            margin: 0;
            font-family: calibri;
            color: #f0f0f0    ;
            width: 40%;
            margin: 0 auto;
        }
        .book-section{
            
        }
        .front#cover, .back#back-cover{
            background: #ffcb63;
            font-family: calibri;
            text-align: left;
            padding: 0 30px;
        }
        .front#cover h1{
            color: #fff;
        }
        .front#cover p{
            color: #fff;
            font-size: 14px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.6);
        }
        #today, #yesterday{
            background-color: #fbfbfb;
            padding: 60px 20px;
            text-align: center;
        }
        section > h2{
            font-size: 28px;
            color: #222;
            font-family: calibri;
            margin: 10px 0 0;
        }
        
        section .no-posts-found{
            display: inline-block;
            text-align: center;
            color: #444;
            margin: 10px 0;
        }
        
        section .no-posts-found a{
            color: dodgerblue;
            text-decoration: none;
        }
        
        section .no-posts-found img.go-post-icon{
            opacity: 0.7;
        }
        
        .book-section > .container {
            height: 530px;
            width: 630px;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2%;
            margin-bottom: 30px;
            perspective: 1200px;
            margin-top: 20px;
        }
        
        @media screen and (max-width:768px){
            section#top-posts{
                padding: 80px 0 40px 0;
            }
            section > p{
                width: 80%;
            }
        }
    </style>
</head>
<body>
    <?php include_once("header.php"); ?>
    <div id="notification"></div>
    <div class="dark-background" id="post-showcase-closer-background"></div>
    <div class="small-window" id="post-showcase">
        <div class="small-window-content" id="small-post-showcase"></div>
    </div>
    <section id="top-posts">
        <?php
        //$sql = "SELECT DISTINCT * FROM photos WHERE uploaddate >= CURRENT_DATE - INTERVAL 5 DAY LIMIT 10";
        $sql = "SELECT * FROM photos";
        include_once("classes/Posts.class.php");
        $Posts = new Posts();
        $imageNames = $Posts->getImagesOfAllPosts($cnctn, $sql);
        $title = "Artistic Designing's Trending Posts";
        $description = "Inside are Top 10 Posts uploaded by our users in last 5 days";
        if(is_array($imageNames) && sizeof($imageNames)>1){
            echo '<div id="book" class="book-section"><div class="container">';
            for($i=0;$i<sizeof($imageNames);$i++){
                echo $Posts->getTheBook($title, $description, $imageNames[$i], sizeof($imageNames), $i);
            }
            echo '</div><button id="prevPage" onclick="turnLeft()">Prev</button> <button id="nextPage" onclick="turnRight()">Next</button><br/></div>';
        }
        else{
            echo "<div class='no-posts-found'><img src='images/sad.png' height='200'><br>Oops! No Trending Posts found<br></div>";
        }
        ?>
        <h1>(Trending Posts)</h1>
        <p>(Trending posts are calculated based on user's interaction with the post. The post with highest likes in lowest time gets highest rank.)</p>
    </section>
    <section id="today">
        <h2>Today's Top Posts</h2>
        <?php
            $sql = "SELECT DISTINCT * FROM photos WHERE uploaddate >= CURRENT_DATE - INTERVAL 0 DAY ORDER BY RAND() LIMIT 10";
            if($query = mysqli_query($cnctn, $sql)){
                $numrows = mysqli_num_rows($query);
                if($numrows < 1){
                    echo "<div class='no-posts-found'><img src='images/sad.png' height='200'><br>Oops! No one posted Today. Be the first one to Post! <a href='user'>Post something amazing <img src='images/interaction/share.png' height='10' class='go-post-icon'></a></div>";
                }
                else{
                    echo "<div id='today-posts' class='posts-holder'>";
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
        ?>
    </section>
    <section id="yesterday">
        <h2>Yesterday's Top Posts</h2>
        <?php
            $sql = "SELECT DISTINCT * FROM photos WHERE uploaddate >= CURRENT_DATE - INTERVAL 1 DAY AND uploaddate <= CURRENT_DATE LIMIT 10";
            if($query = mysqli_query($cnctn, $sql)){
                $numrows = mysqli_num_rows($query);
                if($numrows < 1){
                    echo "<div class='no-posts-found'><img src='images/sad.png' height='200'><br>Oops! No one posted yesterday. <a href='user'>Post something amazing <img src='images/interaction/share.png' height='10' class='go-post-icon'></a></div>";
                }
                else{
                    echo "<div id='yesterday-posts' class='posts-holder'>";
                    while($row = mysqli_fetch_assoc($query)){
                        include_once("classes/Posts.class.php");
                        $Posts = new Posts();
                        echo $Posts->getPosts($cnctn, $user_status, $row);
                    }
                    echo "</div>";
                }
            }
            else{
                echo "Failed to Query";
            }
        ?>
    </section>
    <?php include_once("footer.php"); ?>
</body>
<script src="js/script.js"></script>
<script src="js/post.js"></script>
<script src="js/book.js"></script>
<script>
    var section1 = document.getElementById('today-posts');
    var section2 = document.getElementById('yesterday-posts');
    if(section1 != null)
        useGrids(section1);
    if(section2 != null)
        useGrids(section2);
</script>
</html>