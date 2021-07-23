<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();
$_SESSION;
require("functions/connection.php");
require("functions/methods.php");

$registration = $_POST['registration'];

if ($registration == "success"){

    
    $username= $_POST['user'];
    $id= $_POST['id'];
    $avatar= $_POST['avatar'];
    $user_id = $user_data['user_id'];

    $con = establish_connection();
    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $query = $con->prepare("update accounts set 
        discord_username = '$discord_user',
        discord_id = '$user_id',
        discord_avatar = '$avatar'
    where user_id = '$user_id' limit 1");
    $query->bindParam(":key", $key);
    $result = $query->execute();
    if($result) {
        echo json_encode(array("abc"=>'successfuly registered'));
    } else {
        echo json_encode(array("abc"=>'failed change'));
    }
    die;
    // $query = "update accounts set discord_username = '$discord_user' where user_id = '$user_id' limit 1";
    // mysqli_query($con, $query);
    // $query = "update accounts set discord_id = '$discord_id' where user_id = '$user_id' limit 1";
    // mysqli_query($con, $query);
    // $query = "update accounts set discord_avatar = '$discord_avatar' where user_id = '$user_id' limit 1";
    // mysqli_query($con, $query);
}  