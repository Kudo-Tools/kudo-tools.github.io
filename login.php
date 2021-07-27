<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();
$_SESSION;

require("functions/connection.php");
require("functions/methods.php");

//checks if something was sent to the database
$con = establish_connection();
check_login($con, false);


if($_SERVER['REQUEST_METHOD'] == "POST") {
    $con = establish_connection();
    $key = $_POST['license'];
    if(!empty($key)) {


        $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $query = $con->prepare("SELECT * FROM accounts WHERE license_key = :key LIMIT 1");
        $query->bindParam(":key", $key);
        $query->execute();
        // $result = $query->get_result();
        $user_data = $query->fetch();
        if(!empty($user_data)) {
            // $user_data = $result->fetch_assoc();
            if($key == $user_data['license_key']) {
                $_SESSION['user_id'] = $user_data['user_id'];
                header("Location: dashboard");
                $con = null;
                die;
            } else {
                ?>
                    <style type="text/css">
                        #license_invalid {
                            display: block;
                        }
                    </style>
                <?php
            }
        } else {
            ?>
                <style type="text/css">
                    #license_invalid {
                        display: block;
                    }
                </style>
            <?php
        }
        // $query = "select * from accounts where license_key = '$key' limit 1";
        
        //gets the users data
        // $result = mysqli_query($con, $query);
        
        // if($result) {
            // $user_data = mysqli_fetch_assoc($result);
            // $user_data = $result->fetch_assoc();
            // if($key == $user_data['license_key']) {
            //     $_SESSION['user_id'] = $user_data['user_id'];
            //     header("Location: dashboard");
            //     $con->close();
            //     die;
            // } else {
                ?>
                    <!-- <style type="text/css">
                        #license_invalid {
                            display: block;
                        }
                    </style> -->
                <?php
            // }
        // } else {
            ?>
                <!-- <style type="text/css">
                    #license_invalid {
                        display: block;
                    }
                </style> -->
            <?php
        // }
    }
    $con = null;
}
?>
<html>
    <head>
        <link href="src/styles/main.css" rel="stylesheet" type="text/css">
        <link href="src/styles/header.css" rel="stylesheet" type="text/css">
        <link href="src/styles/BigTitle.css" rel="stylesheet" type="text/css">
        <script src="src/js/features.js"></script>
        <link href="src/styles/login.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <header>
            <img class="logo" href="https://www.kudotools.com" src="images/LoginKudo.png" alt="logo">
            <div class="right_header">
            </div>
        </header>
        <div class="box loginBox">
            <a class="title">Login to Kudo</a>
            <a class="subtitle">Input license key to access dashboard</a>
            <div id="login_element" class="elements">
                <form style="background: transparent;" method="post">
                <a class="error" id="license_invalid">invalid license key</a>
                    <input id="license" type="license" name="license" placeholder="Enter License Key">
                    <button name="login" id="login_button" class="button learn_more" readonly>Login
                        <i class="arrow right"></i>
                    </button>
                    <a class="question">want a free trial?</a>
                    <a onclick="location.href='signup'" class="signup">Sign up here</a>
                </form>
            </div>

        </div>
    </body>
</html>