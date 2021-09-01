<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

function check_login_homepage($con) {
    if(isset($_SESSION["user_id"])) {
        $id = $_SESSION['user_id'];
        $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $query = $con->prepare("select * from accounts where user_id = :id limit 1");
        $query->bindParam(":id", $id);
        $query->execute();
        $user_data = $query->fetch();
        if(!empty($user_data)) {
            return "dashboard";
        }
    }
    return "login";
}

function check_login($con, $fromDashboard) {
    if(isset($_SESSION["user_id"])) {
        //checks if value is legit
        $id = $_SESSION['user_id'];
        $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $query = $con->prepare("select * from accounts where user_id = :id limit 1");
        $query->bindParam(":id", $id);
        $query->execute();
        $user_data = $query->fetch();
        if(!empty($user_data)) {
            if(!$fromDashboard) {
                header("Location: dashboard.php");
            }
            return $user_data;
        }
    }
    if($fromDashboard) {
        $preCodeExist = (array_key_exists("code", $_GET));
        $preCode = ($preCodeExist) ? "?code=".trim($_GET["code"]) : "";
        header("Location: login".$preCode);
        die;
    }
}

function get_stock_availibility($con, $key) {
    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $query = $con->prepare("SELECT * FROM stock WHERE password = :id LIMIT 1");
    $query->bindParam(":id", $key);
    $query->execute();
    $data = $query->fetch();
    if(!empty($data)) {
        return $data['availability'];
    }
    return -1;
}


function get_stock_provider($con, $key) {
    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $query = $con->prepare("SELECT * FROM stock WHERE password = :id LIMIT 1");
    $query->bindParam(":id", $key);
    $query->execute();
    $data = $query->fetch();
    if(!empty($data)) {
        return $data['provider'];
    }
    return "general";
}

/**
 * creates a random number
 */
function random_number($max) {
    $id = "";
    $leng = rand(5, $max);
    for($x = 0; $x < $leng; $x++) {
        $id .= rand(0,9);
    }
    return $id;
}

/**
 * creates a random number
 */
function create_license() {
    $id = "Kudo-";
    for($x = 0; $x < 3; $x++) {
        for($y = 0; $y < 4; $y++) {
            $id .= rand(0,9);
        }
        $id .= "-";
    }
    for($y = 0; $y < 4; $y++) {
        $id .= rand(0,9);
    }
    return $id;
}


?>