<?php

session_start();

    include("classes/connect.php");
    include("classes/login.php");

    //$DB = new Database();
    //$sql = "select * from users";
    //$result = $DB->read($sql);

    //foreach($result as $row){

        //$id = $row['id'];
        //$password = hash("md5", $row['password']);

        //$sql = "update users set password = '$password' where id = '$id' limit 1";

        //$DB->save($sql);
    //}

    //die;

    $email = "";
    $password = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $login = new Login();
        $result = $login->evaluate($_POST);

        if($result != ""){

            echo "<div style='text-align: center; font-size: 20px; color: white; background-color: grey;'>";

            echo "The following errors occured:<br><br>";
            echo $result;
            echo "</div>";

        }
        else{
            header("Location: profile.php");
            die;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

    }
    
    

?>

<html>

    <head>
        <title>WeNet | Log in</title>
    </head>

    <style>
        #bar{
            height:100px;
            background-color: orange;
            color: white;
            padding: 4px;
        }

        #signup_button{
            background-color: red;
            width: 70px;
            text-align: center;
            padding: 4px;
            border-radius: 4px;
            float: right;
        }

        #bar2{
            background-color: white;
            width: 800px;
            margin: auto;
            margin-top: 50px;
            padding: 10px;
            padding-top: 50px;
            text-align: center;
            font-weight: bold;
        }

        #text{
            height: 40px;
            width: 300px;
            border-radius: 4px;
            border: solid 1px #aaa;
            padding: 4px;
            font-size: 14px;
        }

        #button{
            width: 300px;
            height: 40px;
            border-radius: 4px;
            background-color: orange;
            color: white;
            font-weight: bold;
        }
    </style>

    <body style="font-family: tahoma; background-color: #ffe3dd;">
        <div id="bar">
            <div style="font-size: 40px;">WeNet</div>

            <a href="signup.php" >
            <div id="signup_button">Signup</div>
            </a>
        </div>
        <div id="bar2">

            <form method="post">
                Log in to WeNet<br><br>
                <input name="email" value="<?php echo $email ?>" type="text" id="text" placeholder="Email"><br><br>
                <input name="password" value="<?php echo $password ?>" type="password" id="text" placeholder="Password"><br><br>
                <input type="submit" id="button" value="Log in"><br><br>
            </form>

        </div>
    </body>

</html>