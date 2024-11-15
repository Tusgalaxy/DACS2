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

    $Post = new Post();
    $ERROR = "";

    if(isset($_GET['id'])){

        $ROW = $Post->get_one_post($_GET['id']);

        if(!$ROW){
            $ERROR = "No such post was found!";
        }

        else{
            if($ROW['userid'] != $_SESSION['wenet_userid']){

                $ERROR = "Access denied! You cant delete this file!";
            }
        }
    
    }
    else{

        $ERROR = "No such post was found!";

    }
    

    if(isset($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'], "edit.php")){
    
        $_SESSION['return_to'] = $_SERVER['HTTP_REFERER'];
    }

    //if something was posted
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $Post->edit_post($_POST, $_FILES);

        header("Location: ". $_SESSION['return_to']);
        die;
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Delete | WeNet</title>
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

                <!--posts area-->
                <div style="min-height: 400px; flex: 2.5; padding: 20px; padding-right: 0px;">
                    <div style="padding: 10px; background-color: white;">

                        <form method="post" enctype="multipart/form-data">

                                <?php
                                    
                                    if($ERROR != ""){
                                        echo $ERROR;
                                    }
                                    else{
                                        
                                        echo "Edit post<br><br>";

                                        echo '<textarea name="post" placeholder="Whats on your mind?">' . $ROW['post'] . '</textarea>
                                                <input type="file" name="file">';

                                        echo "<input type='hidden' name='postid' value='$ROW[postid]'>";
                                        echo "<input id='post_button' type='submit' value='Save'>";

                                        if(file_exists($ROW['image'])){

                                            $image_class = new Image();

                                            $post_image = $image_class->get_thumb_post($ROW['image']);
                                            echo "<br><br><div style='text-align: center'><img src='$post_image' style='width: 80%;'/></div>";
                                        }
                                    }
                            
                                ?>

                            <br>
                        </form>
                        

                    </div>

                </div>
            </div>
        </div>
    </body>
</html>