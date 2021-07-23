<?php

function check_login($con) {
    //Checks if value is set
    if(isset($_SESSION["user_id"])) {
        //checks if value is legit
        $id = $_SESSION['user_id'];
        $query = "select * from accounts where user_id = '$id' limit 1";
        $result = mysqli_query($con, $query);
        if($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            // header("Location: dashboard.php");
            return $user_data;
        }
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