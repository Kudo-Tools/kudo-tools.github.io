<?php
session_start();
$_SESSION;

require("functions/connection.php");
require("functions/methods.php");

$con = establish_connection();
$key = htmlspecialchars($_GET["key"]);
if(empty($key) || $key == null || trim($key, "") == "") {
    header("Location: signup");
    die;
}

//checks if something was sent to the database
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $query = "select * from accounts where license_key = '$key' limit 1";
    
    //gets the users data
    $result = mysqli_query($con, $query);
    
    if($result) {
        if($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            if($key == $user_data['license_key']) {
                $_SESSION['user_id'] = $user_data['user_id'];
                header("Location: dashboard");
                die;
            }
        } 
    }
    
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
            <img class="logo" href="#" src="images/LoginKudo.png" alt="logo">
            <div class="right_header">
                <a class="sign_up">sign up</a>
               
            </div>
        </header>
        <div class="box loginBox">
            <a class="title">Kudo Account Creation (2/2)</a>
            <a class="subtitle">Save your license key in a save spot</a>
            <div id="login_element" class="elements">
                <form style="background: transparent;" method="post">
                <a class="error" id="license_invalid">invalid license key</a>
                    <input id="license" type="license" name="license" value=<?php echo $key;?>>
                    <button name="login" id="login_button" class="button learn_more" readonly>Login
                        <i class="arrow right"></i>
                    </button>
                </form>
            </div>

        </div>
    </body>
</html>