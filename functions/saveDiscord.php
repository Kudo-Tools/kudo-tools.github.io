<?php 
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

session_start();
$_SESSION;

require("functions/connection.php");
require("functions/methods.php");

$user_data = check_login($con);
$con = establish_connection();
$con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$discord_user = $_POST['username'];
$discord_id = $_POST['id'];
$discord_avatar = $_POST['avatar'];
$user_id = $user_data['user_id'];
$query = $con->prepare("UPDATE accounts SET 
    discord_username = :username, WHERE user_id = :userId LIMIT 1");
$result = $query->execute(
    array(
        ":username" => $discord_user,
        ":userId"=> $user_id
    )
);
$query = $con->prepare("UPDATE accounts SET 
    discord_id = :discId, WHERE user_id = :userId LIMIT 1");
$result = $query->execute(
    array(
        ":discId" => $discord_id,
        ":userId"=> $user_id
    )
);
?>