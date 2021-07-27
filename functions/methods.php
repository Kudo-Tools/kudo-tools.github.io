<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

function check_login($con) {
    //Checks if value is set
    echo $_SESSION["user_id"];
    if(isset($_SESSION["user_id"])) {
        //checks if value is legit
        $id = $_SESSION['user_id'];
        $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $query = $con->prepare("select * from accounts where user_id = :id limit 1");
        $query->bindParam(":id", $id);
        $query->execute();
        $user_data = $query->fetch();
        if(!empty($user_data)) {
            // header("Location: dashboard.php");
            return $user_data;
        }
        // $query = "select * from accounts where user_id = '$id' limit 1";
        // $result = mysqli_query($con, $query);
        // if($result && mysqli_num_rows($result) > 0) {
        //     $user_data = mysqli_fetch_assoc($result);
        //     header("Location: dashboard.php");
        //     return $user_data;
        // }
    }
    //redirects to login page
    header("Location: login");
    die;
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