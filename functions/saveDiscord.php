<?php

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

session_start();
$_SESSION;

include("functions/connection.php");


$registration = $_POST['registration'];
// $name= $_POST['name'];
// $email= $_POST['email'];

if ($registration == "success"){
    // some action goes here under php
    $username= $_POST['user'];
    $id= $_POST['id'];
    $avatar= $_POST['avatar'];
    $user_id = $user_data['user_id'];
    //discord_id = '$id',
    // discord_avatar = '$avatar'
    $con = establish_connection();
    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $query = $con->prepare("update accounts set discord_username = :username where user_id = '$user_id' limit 1");
    $query->bindParam(":username", $username);
    $result = $query->execute();

    echo json_encode(array(
        "result"=>'successfuly registered',
        "user"=>$username,
        "avatar"=>$avatar,
        "id"=>$id
    ));
}   
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

// session_start();
// $_SESSION;
// require("functions/connection.php");
// require("functions/methods.php");

// $registration = $_POST['registration'];

// echo '<script>console.log("outside function");</script>';
// echo "CALLED THE HIDDEN FUNCTION!";

// if ($registration == "success"){

//     echo "CALLED THE HIDDEN FUNCTION INSIDE!";
//     echo '<script>console.log("Inside function");</script>';
    
//     $username= $_POST['user'];
//     $id= $_POST['id'];
//     $avatar= $_POST['avatar'];
//     $user_id = $user_data['user_id'];

//     echo '<script>console.log("starting connection");</script>';

//     $con = establish_connection();
//     $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
//     $query = $con->prepare("update accounts set 
//         discord_username = '$discord_user',
//         discord_id = '$user_id',
//         discord_avatar = '$avatar'
//     where user_id = '$user_id' limit 1");
//     $query->bindParam(":key", $key);

//     echo '<script>console.log("sending connection");</script>';

    // $result = $query->execute();


    // if($result) {
    //     echo json_encode(array("abc"=>'successfuly registered'));
    // } else {
    //     echo json_encode(array("abc"=>'failed change'));
    // }

    // echo '<script>console.log("done sending");</script>';

    // die;
    // $query = "update accounts set discord_username = '$discord_user' where user_id = '$user_id' limit 1";
    // mysqli_query($con, $query);
    // $query = "update accounts set discord_id = '$discord_id' where user_id = '$user_id' limit 1";
    // mysqli_query($con, $query);
    // $query = "update accounts set discord_avatar = '$discord_avatar' where user_id = '$user_id' limit 1";
    // mysqli_query($con, $query);
// }
?>  