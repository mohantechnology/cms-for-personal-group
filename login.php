<?php

$error = "";
session_start();

if (isset($_SESSION['message']) &&  $_SESSION['message'] == "admin") {



    if (isset($_REQUEST["mobile_no"]) && isset($_REQUEST["password"])) {
        
        include "user_password.php";
        $mobile_no = trim($_REQUEST["mobile_no"]);
        $password = trim($_REQUEST["password"]);
      //mobile no and password
        if (strcmp($mobile_no, $user_name) === 0 && strcmp($password, $user_password) === 0) {
           
            $_SESSION["admin_ps"] = $user_password;
        
            header("location:upload_file.php");
        }
        if (strlen($mobile_no) !== 10) {

            $error = "Please Enter a valid mobile number";
        }else if( strcmp($password,$user_password) != 0){
            $error = "Wrong Password";
        }
        else if( strcmp($mobile_no,$user_name) != 0){
            $error = "Your are Not the correct user";
        }

    }
} else {
    header("location:ssipmt.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
</head>

<style>
    body {

        margin: 0px;
        padding: 0px;
        height: 100vh;
        /* background-color: rgb(34, 34, 34); */
        background-image: url(img3.jpg);
        background-repeat: no-repeat;
        background-size: cover;


        /* background-size: 100%; */

    }

    #form_boundary {

        width: 220px;
        margin: auto;
        /* display: flex; */

        border-style: solid;
        padding: 10px;
        position: relative;
        top: 30px;
        border-radius: 3px;
        border-color: rgb(231, 221, 255);
        /* opacity:0.9; */



        border-width: 1px;
        text-align: center;

        background-color: rgba(0, 0, 0, 0.6);

    }



    ::placeholder {
        color: rgb(233, 197, 197);
        opacity: 1;

    }

    :-ms-input-placeholder {
        color: rgb(233, 197, 197);
    }

    ::-ms-input-placeholder {
        color: rgb(233, 197, 197);
    }

    input {
        margin-bottom: 15px;
        position: relative;
        width: 80%;
        color: rgb(255, 255, 255);
        background: transparent;
    }

    button {

        /* background-color: rgb(24, 145, 145); */
        background-color: black;
        color: black;
        font-size: 15px;
        width: 83%;
    }

    button:hover {
        /* background-color: rgb(24, 168, 168); */
        box-shadow: 0px 0px 5px 1px white;


    }

    button:focus,
    input:focus {
        /* background-color: rgb(24, 168, 168); */
        box-shadow: 0px 0px 5px 1px white;


    }

    a {
        text-decoration: none;
        color: rgb(205, 205, 222);
        ;
    }

    a:hover {
        /* text-decoration: none; */
        color: rgb(5, 4, 255);
        ;

    }
</style>

<body>


    <div id="form_boundary">
        <form action="" method="post">
            <p style="font-weight: 800;font-size:larger ;color:white"> Login</p>
            <hr>

            <?php if ($error != "") echo "<p id='message' style='color:white'>$error<p>"; ?>
            <br><input required type="text" name="mobile_no" placeholder="Enter your Phone Number">
            <br><input required type="password"  name="password" placeholder="Enter your Password">
            <br><button style="color:whitesmoke" type="submit" name="login">Log In</button>

            <a href="recover_password_php.php">
                <p>Forgot password?</p>
            </a>
            <p style="color:white">Don't have an account? &nbsp;<a href="registration_form.php">Sign up</a></p>

        </form>

    </div>

    <div id="img">
    </div>
    <script>
        var message = document.getElementById("message");
        setTimeout(() => {
            if(message)
            message.style.display = "none";
        }, (5000));
    </script>
</body>

</html>