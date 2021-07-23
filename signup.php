<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();
$_SESSION;
require("functions/connection.php");
require("functions/methods.php");
try {
    $error = htmlspecialchars($_GET["error"]);
    if(!empty($error)) {
        ?>
            <style type="text/css">
                #license_not_found {
                    display: block;
                }
            </style>
        <?php
    } else {
        ?>
            <style type="text/css">
                #license_not_found {
                    display: none;
                }
            </style>
        <?php
    }
} catch (exception $e) {
    ?>
        <style type="text/css">
            #license_not_found {
                display: none;
            }
        </style>
    <?php
}
 

$key = "no license key";
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $con = establish_connection();
    if (isset($_POST['create'])) {
        if($con != null) {
            $user_id = random_number(25);
            $license = create_license();
            $items_base = "[]";
            $acc = "trial";
            
            try {
                $data = array($user_id, $license, $items_base, $acc);
                $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $query = $con->prepare("insert into accounts (user_id, license_key, items, account_type) values (?, ?, ?, ?)");
                if($query->execute($data)) {
                    $key = $license;
                    header("Location: welcome?key=".$key);
                    $con = null;
                    die;
                } else {
                    header("Location: signup?error=invalid");
                    $con = null;
                    die;
                }
            } catch(exception $e) {
                header("Location: signup?error=invalid");
                $con = null;
                die;
            }
            // $query = $con->prepare("select * from accounts where license_key = :key limit 1");
            // $query->bindParam(":key", $key);
            // $query->execute();

            // $success = mysqli_query($con, $query);
        } else {
            echo "Couldn't connect to database";
            $con = null;
            die;
        }
        
    }
    elseif (isset($_POST['login'])) {
        echo "Login button detected";
        $license = $key;
        if(!empty($license)) {
            $query = "select * from accounts where license_key = '$license' limit 1";
            $result = mysqli_query($con, $query);
            if($result) {
                if($result && mysqli_num_rows($result) > 0) {
                    $user_data = mysqli_fetch_assoc($result);
                    if($license == $user_data['license_key']) {
                        $_SESSION['user_id'] = $user_data['user_id'];
                        header("Location: dashboard");
                        $con = null;
                        die;
                    } else {
                        ?>
                        <style type="text/css">
                            #license_not_found {
                                display: block;
                            }
                        </style>
                        <?php
                    }
                } else {
                    ?>
                    <style type="text/css">
                        #license_not_found {
                            display: block;
                        }
                    </style>
                    <?php
                }
            }
        }
    } else {
        echo "No button detected";
        $con = null;
        die;
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
            <img class="logo" href="#" src="images/LoginKudo.png" alt="logo">
            <div class="right_header">
                <a class="sign_up">login</a>
               
            </div>
        </header>
        <div class="box loginBox">
            <a class="title">Kudo Account Creation (1/2)</a>
            <a class="subtitle">Sign-up for a free trial version of Kudo</a>
            <a class="error" id="license_not_found">error generating key, try again in a minute</a>
            <div id="create_key" class="elements">
                <form style="background: transparent;" method="post">
                    <button name="create" style="margin-top: 20px;" id="beta_button">create free beta key</button>
                    <a class="question">already have an account?</a>
                    <a onclick="location.href='login'" class="signup">Login here</a>
                </form>
            </div>

            <!-- <div id="login_element" class="elements">
                <form style="background: transparent;" method="post">
                <a style="display:none;" class="error" id="license_invalid">invalid license key</a>
                    <input id="license" type="license" name="license" value=<?php echo $key;?>>
                    <button name="login" id="login_button" class="button learn_more" readonly>Login
                        <i class="arrow right"></i>
                    </button>
                </form>
            </div> -->

        </div>
    </body>
</html>