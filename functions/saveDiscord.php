<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');

echo "starting...";
session_start();
$_SESSION;

require("functions/connection.php");
require("functions/methods.php");

$user_data = check_login($con);
echo "creating connection";
$con = establish_connection();
$con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$discord_user = $_POST['username'];
$discord_id = $_POST['id'];
$discord_avatar = $_POST['avatar'];
$user_id = $user_data['user_id'];
echo "sending...";
$query = $con->prepare("UPDATE accounts SET discord_username = :username,  discord_id = :discId,  discord_avatar = :discAvatar WHERE user_id = :userId LIMIT 1");
$result = $query->execute(
    array(
        ":username" => $discord_user,
        ":discId" => $discord_id,
        ":discAvatar" => $discord_avatar,
        ":userId"=> $user_id
    )
);
echo "sent!";
?>