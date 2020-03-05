<?php
include_once("includes/check_login.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="utf-8" />
    <meta name="description" content="Free to use Artworks, Vectors, Designs, Material Designs, Website Designs, Application Designs, Logos, Brochures, Invitation Cards &amp; much more." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Artistic Designing</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/post.css" />
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <title>Search results | Artistic Designing</title>
<style>
    #search-results{
        padding: 150px 0 50px;
        box-shadow: none;
        background-color: white;
    }
    .no-of-results{
        margin-left: 20px;
        font-size: 18px;
        font-family: my_font;
        color: #333;
    }
@media only screen and (max-width: 768px)
{
    #search-results
    {
        padding: 60px 0 40px;
    }
}
</style>
</head>
	
<body>

<?php include_once 'header.php'; ?>
<div class="dark-background" id="post-showcase-closer-background"></div>
<div class="small-window" id="post-showcase">
    <div class="small-window-content" id="small-post-showcase"></div>
</div>
<section id="search-results">
    <?php
    if(isset($_GET['search_terms'])){
        $searchQuery = mysqli_real_escape_string($cnctn, $_GET["search_terms"]);
        if($searchQuery == null){
            echo "<h2 class='no-results'>Search terms not found</h2>";
        }
        else{
            $sql = "SELECT * FROM photos WHERE title like '%$searchQuery%' OR `description` like '%$searchQuery%'";
            if($query = mysqli_query($cnctn, $sql)){
                $numrows = mysqli_num_rows($query);
                if($numrows < 1){
                    echo "<h2 class='no-results'>Oops! No posts found with keywords '$searchQuery'</h2>";
                }
                else{
                    echo "<div class='posts-holder' id='search-result-posts'>";
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
        }
    }
    else{
        echo "<script>window.history.back();</script>";
        mysqli_close($cnctn);
        exit();
    }
    ?>
</section>
<script src="js/script.js"></script>
<script src="js/post.js"></script>
<script>
    var section1 = document.getElementById('search-result-posts');
    if(section1 != null)
        useGrids(section1);
</script>
<?php include_once 'footer.php'; ?>
</body>
</html>