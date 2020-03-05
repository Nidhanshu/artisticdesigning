<?php
if($user_status == true)
{
    $usr = mysqli_real_escape_string($cnctn, $_SESSION["username"]);
    $sql = "SELECT avatar FROM users WHERE username='$usr' LIMIT 1";
    $query = mysqli_query($cnctn, $sql);
    $numrows = mysqli_num_rows($query);
    if($numrows > 0)
    {
        $row = mysqli_fetch_assoc($query);
        $avataricon = $row["avatar"];
    }
    else
    {
        $avataricon = 'images/male.png';
    }
}
?>
<header id="menu" onMouseLeave="closeSearch()">
    <form action="results" method="get" id="search-form">
        <div class="search-box">
            <input type="search" id="input-search" name="search_terms" oninput="ajaxpost(event)" autocomplete="off" required>
            <label id="placeholder" for="input-search">Type to search</label>
            <div id="ajax-results" class="ajax-results"></div>
        </div>
        <input type="submit" value="Search" id="search-button" class="button" />
    </form>
    <ul class="large-list">
        <li title="Home"><a href="index"><img src="images/logo.svg" class="logo-img" alt="Home" />Home</a></li>
        <li><a href="about">About Us</a></li>
        <?php if($user_status == true){echo '';}else{echo '<li><a href="login">Login</a></li>
        <li><a href="signup">Sign Up</a></li>';} ?>
        <?php
        if($user_status == true){
            echo '<li><a href="user?u='.$usr.'"><div class="user-img" style="background-image:url(\'users/'.$usr.'/'.$avataricon.'\');" title="'.$usr.'"></div>@'.$usr.'</a></li>'; 
        }
        ?>
        <li onClick="searchToCross()">
            <div id="search-holder">
                <div id="search-circle" class="search-circle"></div>
                <div id="search-line" class="search-line"></div>
            </div>
        </li>
    </ul>
    <div id="res-menu">
        <span onclick="showSmallList()"><div class="sidebar-btn"></div></span>
        <a href="index"><img src="images/logo.svg" style="filter:drop-shadow(1px 1px 3px rgba(0,0,0,0.5)); margin-bottom:-5px;" height="35px" width="35px" alt="Home" /></a>
        <a href="<?php if($user_status == true){echo 'user?u='.$usr;} else{echo 'login';} ?>"><div class="profile-link" style="background-image:url(<?php if($user_status == true){echo 'users/'.$usr.'/'.$avataricon;}else{echo 'images/male.png';} ?>);" title="<?php if($user_status == true){echo $usr;} else{echo 'Login';} ?>"></div></a>
    </div>
</header>
<sidebar>
    <ul class="small-list">
       <li><form action="search" method="get" id="s-search-form">
            <div class="search-box">
                <input type="search" id="s-input-search" name="sm-search_terms" oninput="ajaxpost(event)" autocomplete="off" required>
                <label id="s-placeholder" for="s-input-search">Type to search</label>
                <div id="s-ajax-results" class="ajax-results"></div>
            </div>
            <input type="submit" value="Search" id="s-search-button" class="button" />
        </form></li>
        <li><a href="about">About us</a></li>
        <?php if($user_status == true){echo '';}else{echo '<li><a href="login">Login</a></li>
        <li><a href="signup">Sign Up</a></li>';} ?>
    </ul>
</sidebar>