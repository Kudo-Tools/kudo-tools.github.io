<?php 
session_start();
$_SESSION;
include("functions/connection.php");
include("functions/methods.php");
$matchFound = (array_key_exists("key", $_GET));
if($matchFound) {
    $key = htmlspecialchars($_GET["key"]);
    if(!empty($key) && $key != NULL && trim($key, "") != "") {
        $con = establish_connection();
        $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $query = $con->prepare("SELECT * FROM accounts WHERE license_key = :key LIMIT 1");
        $query->bindParam(":key", $key);
        $query->execute();
        $user_data = $query->fetch();
        if(!empty($user_data)) {
            $id = $user_data["user_id"];
            $license = $user_data["license_key"];
            $discordId = $user_data["discord_id"];
            $discordAvatar = $user_data["discord_avatar"];
            $discordUsername = $user_data["discord_username"];
            $dateJoined = $user_data["date"];
            $items = $user_data["items"];
            $type = $user_data["account_type"];
           
            $data = [ 
                'user id' => $id, 
                'license' => $license,
                "discord id" =>  $discordId ,
                "discord avatar" => $discordAvatar,
                "discord username" => $discordUsername,
                "date joined" => $dateJoined,
                "items" => $items,
                "type" => $type
            ];
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            echo "Invalid License Key";
            die;
        }
    } else {
        echo "No License Key Provided";
        die;
    }
} else {
    echo "No Parameters Provided";
    die;
}

?>