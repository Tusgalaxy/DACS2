<!--top bar-->

<?php
    $corner_image = "img/avatar.jpg";
    if(isset($USER) && file_exists($USER['profile_image'])){

        $image_class = new Image();
        //$corner_image = $user_data['profile_image'];
        $corner_image = $image_class->get_thumb_profile($USER['profile_image']);
    }

?>

<div id="blue_bar">
    <form method="get" action="search.php">
        <div style="width: 800px; margin: auto; font-size: 30px;">
            <a href="index.php" style="color: white">
                WeNet
            </a>

            
                &nbsp &nbsp <input type="text" id="search_box" name="find" placeholder="Search for people">
            

            <a href="profile.php">
                <img src="<?php echo $corner_image ?>" style="width: 50px; float: right; border-radius: 50%;">
            </a>


            <a href="logout.php">
            <span style="font-size: 11px; float: right; margin: 10px; color: white;">Logout</span>
            </a>


        </div>
    </form>
</div>