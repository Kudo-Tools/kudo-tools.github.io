<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();
$_SESSION;
require("functions/connection.php");
require("functions/methods.php");
$matchFound = (array_key_exists("error", $_GET));
if($matchFound) {
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
} else {
    ?>
        <style type="text/css">
            #license_not_found {
                display: none;
            }
        </style>
    <?php
}
$availability = NULL;
$passMatch = (array_key_exists("pass", $_GET));
if($passMatch) {
    $val = htmlspecialchars($_GET["pass"]);
    if(!empty($val)) {
        $amt = get_stock_availibility($con, $val);
        if($amt > 0) {
            $availability = "create a free beta key";
        } else {
            $availability = "out of stock";
        }
    } else {
        $amt = get_stock_availibility($con, "general");
        if($amt > 0) {
            $availability = "create a free beta key";
        } else {
            $availability = "out of stock";
        }
    }
} else {
    $amt = get_stock_availibility($con, "general");
    if($amt > 0) {
        $availability = "create a free beta key";
    } else {
        $availability = "out of stock";
    }
}
 

$key = "no license key";
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $con = establish_connection();
    if ($availability != "out of stock" && isset($_POST['create'])) {
        if($con != null) {
            $user_id = random_number(25);
            $license = create_license();
            $items_base = "[]";
            $acc = "trial";
            $instances = "2/2";

            try {
                $data = array($user_id, $license, $items_base, $acc, $instances);
                $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

                $query = $con->prepare(
                    "INSERT INTO accounts 
                    (user_id, license_key, items, account_type, instances) 
                    VALUES 
                    (?, ?, ?, ?, ?)");
                if($query->execute($data)) {
                    $key = $license;
                    header("Location: welcome?key=".$key);
                    $con = null;
                    die;
                } else {
                    print_r($con->errorInfo());
                    die;
                    header("Location: signup?error=invalid");
                    $con = null;
                    die;
                }
            } catch(exception $e) {
                header("Location: signup?error=invalidBAD");
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
        <title>Signup for Kudo</title>
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
                <a onclick="location.href='login'" class="sign_up">login</a>
               
            </div>
        </header>
        <div class="box loginBox">
            <a class="title">Kudo Account Creation (1/2)</a>
            <a class="subtitle">Sign-up for a free trial version of Kudo</a>
            <a class="error" id="license_not_found">error generating key, try again in a minute</a>
            <div id="create_key" class="elements">
                <form style="background: transparent;" method="post">
                    <button name="create" style="margin-top: 20px;" id="beta_button"><?php echo $availability?></button>
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