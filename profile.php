<?php

    //echo "<pre>";
    //print_r($_GET);
    //echo "</pre>";

    //unset($_SESSION['wenet_userid']);

    include("classes/autoload.php");

    $login = new Login();
    $user_data = $login->check_login($_SESSION['wenet_userid']);

    $USER = $user_data;

    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        
        $profile = new Profile();
        $profile_data = $profile->get_profile($_GET['id']);

        if(is_array($profile_data)){

            $user_data = $profile_data[0];

        }

    }
    
    
    //echo "<pre>";
    //print_r($profile_data);
    //echo "</pre>";

    //isset($_SESSION['wenet_userid']);
    

    //posting
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        if(isset($_POST['first_name'])){

            $settings_class = new Settings();
            $settings_class->save_settings($_POST, $_SESSION['wenet_userid']);

        }
        else{
                
            $post = new Post();

            $id = $_SESSION['wenet_userid'];
            $result = $post->create_post($id, $_POST, $_FILES);
            
            if($result == ""){
                header("Location: profile.php");
                die;
            }
            else{
                echo "<div style='text-align: center; font-size: 20px; color: white; background-color: grey;'>";

                echo "The following errors occured:<br><br>";
                echo $result;
                echo "</div>";

            }
        }

        
    }

    //collect posts
    $post = new Post();
    $id = $user_data['userid'];
    $posts = $post->get_posts($id);

    //collect friends
    $user = new User();
    $id = $user_data['userid'];
    $friends = $user->get_following($user_data['userid'], "user");

    $image_class = new Image();


?>



<!DOCTYPE html>
<html>
    <head>
        <title>Profile | WeNet</title>
    </head>
    <style type="text/css">
        #blue_bar{
            height: 50px;
            background-color:orange;
            color:white;
        }

        #search_box{
            width: 400px;
            height: 20px;
            border-radius: 5px;
            border: none;
            padding: 4px;
            font-size: 14px;
            background-image: url("img/search.png");
            background-repeat: no-repeat;
            background-position: right;
        }

        #textbox{
            width: 100%;
            height: 20px;
            border-radius: 5px;
            border: none;
            padding: 4px;
            font-size: 14px;
            border: solid thin grey;
            margin: 10px;
        }

        #profile_pics{
            width: 150px;
            margin-top: -200px;
            border-radius: 50%;
            border: solid 2px white;
        }
        
        #menu_buttons{
            width: 100px;
            display: inline-block;
            margin: 2px;
        }

        #friends_img{
            width: 100px;
            float: left;
            border-radius: 50%;
            margin: 8px;
        }

        #friends_bar{
            background-color: white;
            min-height: 400px;
            margin-top: 20px;
            color: #aaa;
            padding: 8px;
        }

        #friends{
            clear: both;
            font-size: 12px;
            font-weight: bold;
            color: orange;
        }

        textarea{
            width: 100%;
            border: none;
            font-family: tahoma;
            font-size: 14px;
            height: 60px;

        }

        #post_button{
            float: right;
            background-color: orange;
            border: none;
            color: white;
            padding: 4px;
            font-size: 14px;
            border-radius: 2px;
            width: 50px;
            min-width: 50px;
            cursor: pointer;
        }

        #post_bar{
            margin-top: 20px;
            background-color: white;
            padding: 10px;
        }

        #post{
            padding: 4px;
            font-size: 13px;
            display: flex;
            margin-bottom: 20px;
        }



    </style>
    <body style="font-family: tahoma; background-color: #ffe3dd;">

        <?php include("header.php"); ?>

        <!--cover area-->
        <div style="width: 800px; margin: auto; background-color: #ffe3dd; min-height: 400px;">
            <div style="background-color: white; text-align: center; color: black;">

                <?php
                    $image = "img/back.jpg";
                    if(file_exists($user_data['cover_image'])){

                        $image = $image_class->get_thumb_cover($user_data['cover_image']);

                    }

                ?>
                <img src="<?php echo $image ?>" style="width: 100%">

                

                <span style="font-size: 11px;">

                    <?php
                        $image = "img/avatar.jpg";
                        if(file_exists($user_data['profile_image'])){

                            $image = $image_class->get_thumb_profile($user_data['profile_image']);

                        }

                    ?>

                    <img src="<?php echo $image ?>" id="profile_pics"><br>

                    <a href="change_profile_image.php?change=profile" style="text-decoration: none; color: #f0f">
                        Change Avatar
                    </a> | 
                    <a href="change_profile_image.php?change=cover" style="text-decoration: none; color: #f0f">
                        Change Background
                    </a>

                </span>


                <div style="font-size: 20px;">

                    <a href="profile.php?id=<?php echo $user_data['userid'] ?>" style="text-decoration: none;">
                        <?php echo $user_data['first_name'] . " " . $user_data['last_name']?>
                        <br>
                    </a>
                    
                    <!--follow-->
                    <?php

                        $mylikes = "";

                        if($user_data['likes'] > 0){
                            $mylikes = "(" . $user_data['likes'] . " followers)";
                        }

                    ?>

                    <a href="like.php?type=user&id=<?php echo $user_data['userid'] ?>">

                    <input id="post_button" type="submit" value="Follow <?php echo $mylikes ?>" style="margin-right: 10px; width: auto;">
                    </a>
                
                </div>
                <br>

                <a href="index.php"><div id="menu_buttons">Timeline</div></a>
                <a href="profile.php?section=about&id=<?php echo $user_data['userid'] ?>"><div id="menu_buttons">About</div></a>
                <a href="profile.php?section=followers&id=<?php echo $user_data['userid'] ?>"><div id="menu_buttons">Followers</div></a>
                <a href="profile.php?section=following&id=<?php echo $user_data['userid'] ?>"><div id="menu_buttons">Following</div></a>
                <a href="profile.php?section=photos&id=<?php echo $user_data['userid'] ?>"><div id="menu_buttons">Photos</div></a>
                
                <?php

                        if($user_data['userid'] == $_SESSION['wenet_userid']){

                            echo '<a href="profile.php?section=settings&id='.$user_data['userid'].'"><div id="menu_buttons">Settings</div></a>';

                        }

                ?>

            </div>
            
            <!--below cover area-->

            <?php

                $section = "default";

                if(isset($_GET['section'])){

                    $section = $_GET['section'];
                }

                if($section == "default"){
                        
                    include("profile_content_default.php");
                }
                else if($section == "following"){

                    include("profile_content_following.php");
                }
                else if($section == "followers"){

                    include("profile_content_followers.php");
                }
                else if($section == "about"){

                    include("profile_content_about.php");
                }
                else if($section == "settings"){

                    include("profile_content_settings.php");
                }
                else if($section == "photos"){

                    include("profile_content_photos.php");
                }


            ?>
            
        </div>
    </body>
</html>