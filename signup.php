<?php

    include("classes/connect.php");
    include("classes/signup.php");

    $first_name = "";
    $last_name = "";
    $gender = "";
    $email = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $signup = new Signup();
        $result = $signup->evaluate($_POST);

        if($result != ""){

            echo "<div style='text-align: center; font-size: 20px; color: white; background-color: grey;'>";

            echo "The following errors occured:<br><br>";
            echo $result;
            echo "</div>";

        }
        else{
            header("Location: login.php");
            die;
        }

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];

    }
    
?>


<html>

    <head>
        <title>WeNet | Signup</title>
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
            <div style="font-size: 40px;">WeNet</div>\

            <a href="login.php" >
            <div id="signup_button">Log in</div>
            </a>
        </div>
        <div id="bar2">
            Sign up to WeNet<br><br>

            <form method="post" action="signup.php">

                <input value="<?php echo $first_name ?>" name="first_name" type="text" id="text" placeholder="First Name"><br><br>
                <input value="<?php echo $last_name ?>" name="last_name" type="text" id="text" placeholder="Last Name"><br><br>

                <span style="font-weight: normal;">Gender:</span><br>
                <select id="text" name="gender">
                    <option><?php echo $gender ?></option>
                    <option>Male</option>
                    <option>Female</option>
                </select>
                <br><br>

                <input value="<?php echo $email ?>" name="email" type="text" id="text" placeholder="Email"><br><br>

                <input name="password" type="password" id="text" placeholder="Password"><br><br>
                <input name="password2" type="password" id="text" placeholder="Confirm Password"><br><br>

                <input type="submit" id="button" value="Signup"><br><br>

            </form>

        </div>
    </body>

</html>