<?php
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

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $post = new Post();

        $id = $_SESSION['wenet_userid'];
        $result = $post->create_post($id, $_POST, $_FILES);
        
        if($result == ""){
            header("Location: index.php");
            die;
        }
        else{
            echo "<div style='text-align: center; font-size: 20px; color: white; background-color: grey;'>";

            echo "The following errors occured:<br><br>";
            echo $result;
            echo "</div>";

        }
    }

    //collect posts
    $post = new Post();
    $id = $user_data['userid'];
    $posts = $post->get_posts($id);

    //collect friends
    $user = new User();
    $id = $user_data['userid'];
    $friends = $user->get_friends($id);

    

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
            background-image: url(img/search-icon.png);
            background-repeat: no-repeat;
            background-position: right;
        }

        #profile_pics{
            width: 150px;
            border-radius: 50%;
            border: solid 2px white;
        }
        
        #menu_buttons{
            width: 100px;
            display: inline-block;
            margin: 2px;
        }

        #friends_img{
            width: 75px;
            float: left;
            border-radius: 50%;
            margin: 8px;
        }

        #friends_bar{
            min-height: 400px;
            margin-top: 20px;
            padding: 8px;
            text-align: center;
            font-size: 20px;
            color: orange;
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

        <!--top bar-->
        <?php include("header.php") ?>

        <!--cover area-->
        <div style="width: 800px; margin: auto; background-color: #ffe3dd; min-height: 400px;">
            
            
            <!--below cover area-->
            <div style="display: flex;">
                <!--friends area-->
                <div style="min-height: 400px; flex: 1;">
                    <div id="friends_bar">
                        
                        <?php
                            $image = "img/avatar.jpg";
                            if(file_exists($user_data['profile_image'])){

                                $image = $image_class->get_thumb_profile($user_data['profile_image']);

                            }

                        ?>
                        
                        <a href="profile.php" style="text-decoration: none">

                            <img src="<?php echo $image ?>" id="profile_pics"><br>

                        
                            <?php echo $user_data['first_name'] . " " . $user_data['last_name'] ?>
                        </a>

                    </div>
                </div>

                <!--posts area-->
                <div style="min-height: 400px; flex: 2.5; padding: 20px; padding-right: 0px;">
                    <div style="padding: 10px; background-color: white;">
                        
                        <form method="post" enctype="multipart/form-data">

                            <textarea name="post" placeholder="Whats on your mind?"></textarea>

                            <input type="file" name="file">

                            <input id="post_button" type="submit" value="Post">

                            <br>
                        </form>

                    </div>

                    
                    <!--posts-->
                    <div id="post_bar">

                        <?php

                            $DB = new Database();
                            $user_class = new User();
                            $image_class = new Image();

                            $followers = $user_class->get_following($_SESSION['wenet_userid'], "user");

                            $follower_ids = false;

                            if(is_array($followers)){

                                $follower_ids = array_column($followers, "userid");

                                $follower_ids = implode("','", $follower_ids);

                            }

                            if($follower_ids){

                                $myuserid = $_SESSION['wenet_userid'];
                                    
                                $sql = "select * from posts where parent = 0 and userid = '$myuserid' or userid in('" .$follower_ids. "') order by id desc limit 30";

                                $posts = $DB->read($sql);

                            }

                            if(isset($posts) && $posts){
                                
                                foreach ($posts as $ROW){

                                    $user = new User();

                                    $ROW_USER = $user->get_user($ROW['userid']);

                                    include("post.php");
                                }
                            }
                                            
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </body>
</html>