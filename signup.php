<?php
session_start();
$_SESSION;
include("functions/connection.php");
include("functions/methods.php");
$key = "no license key";
if($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['create'])) {
        $user_id = random_number(25);
        $license = create_license();
        $items_base = "[]";
        $acc = "trial";
        $query = "insert into accounts (user_id, license_key, items, account_type) values ($user_id, $license, $items_base, $acc)";
        $success = mysqli_query($con, $query);
        if($success) {
            $key = $license;
            ?>
                <style type="text/css">
                    #login_element {
                        display: block;
                    }
                    #create_key {
                        display: none;
                    }
                </style>
            <?php
        } else {
            ?>
                <style type="text/css">
                    #license_not_found {
                        display: block;
                    }
                </style>
            <?php
            echo "Could Not Query";
            die;
        }
    }
    elseif (isset($_POST['login'])) {
        echo "Login button detected";
        $license = $key;
        if(!empty($license)) {
            $query = "select * from accounts where license_key = $license limit 1";
            $result = mysqli_query($con, $query);
            if($result) {
                if($result && mysqli_num_rows($result) > 0) {
                    $user_data = mysqli_fetch_assoc($result);
                    if($license == $user_data['license_key']) {
                        $_SESSION['user_id'] = $user_data['user_id'];
                        header("Location: dashboard");
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
        }
    } else {
        echo "No button detected";
        die;
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
            <a class="title">Kudo Account Creation</a>
            <a class="subtitle">Sign-up for a free trial version of Kudo</a>
            <a style="display:none;" class="error" id="license_not_found">error generating key</a>
            <div style="display:block;" id="create_key" class="elements">
                <form style="background: transparent;" method="post">
                    <button name="create" style="margin-top: 20px;" id="beta_button">create free beta key</button>
                    <a class="question">already have an account?</a>
                    <a onclick="location.href='login'" class="signup">Login here</a>
                </form>
            </div>

            <div style="display:none;" id="login_element" class="elements">
                <form style="background: transparent;" method="post">
                <a style="display:none;" class="error" id="license_invalid">invalid license key</a>
                    <input id="license" type="license" name="license" value=<?php echo $key;?>>
                    <button name="login" id="login_button" class="button learn_more" readonly>Login
                        <i class="arrow right"></i>
                    </button>
                </form>
            </div>

        </div>
    </body>
</html>