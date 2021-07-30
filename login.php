<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
session_start();
$_SESSION;

require("functions/connection.php");
require("functions/methods.php");

//checks if something was sent to the database
$matchFound = (array_key_exists("code", $_GET));
$extension = ($matchFound) ? "?code=".trim($_GET["code"]) : "";

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
        $user_data = $query->fetch();
        if(!empty($user_data)) {
            if($key == $user_data['license_key']) {
                $_SESSION['user_id'] = $user_data['user_id'];
                header("Location: dashboard".$extension);
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
    }
    $con = null;
}
?>
<html>
    <head>
        <title>Login to Kudo</title>
        <link href="src/styles/main.css" rel="stylesheet" type="text/css">
        <link href="src/styles/header.css" rel="stylesheet" type="text/css">
        <link href="src/styles/BigTitle.css" rel="stylesheet" type="text/css">
        <script src="src/js/features.js"></script>
        <link href="src/styles/login.css" rel="stylesheet" type="text/css">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
    </head>
    <body>
        <header>
            <img class="logo" onclick="window.location='https://www.kudotools.com/'" src="images/LoginKudo.png" alt="logo">
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