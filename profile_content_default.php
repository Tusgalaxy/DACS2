<div style="display: flex;">
<!--following area-->
<div style="min-height: 400px; flex: 1; text-align: center;">
    <div id="friends_bar">
        Following<br>

            <?php

                if($friends){

                    foreach ($friends as $friend){

                        $FRIEND_ROW = $user->get_user($friend['userid']);

                        include("user.php");
                    }
                }

            ?>

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

            if($posts){
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