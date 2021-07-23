<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();
$_SESSION;

require("functions/connection.php");
require("functions/methods.php");


//if logged in this contains user info
$con = establish_connection();
$user_data = check_login($con);


$fullDiscordName = $user_data['discord_username'];
$license = $user_data['license_key'];
$discordId = $user_data['discord_id'];
$discordAvatar = $user_data['discord_avatar'];
$discord_Avatar_Image = '';
$discordName = '';
$discordNameNumbers = '';

// try {
    // $discordToAdd = htmlspecialchars($_GET["code"]);
    // if(!empty($discordToAdd)) {
    //     // updateDiscordInformation();
    //     // header("Location: dashboard");
    //     echo "DISCORD IS SUPPOSE TO BE ADDED";
    //     die;
    // }
// } catch (exception $e) {}

function updateDiscordInformation() {
    $discord_avatar = $_POST['avatar'];
    $discord_user = $_POST['discord_user'];
    $discord_id = $_POST['discord_id'];
    $license_key = $_POST['license_key'];
    $user_id = $user_data['user_id'];
    $query = "update accounts set discord_username = '$discord_user' where user_id = '$user_id' limit 1";
    mysqli_query($con, $query);
    $query = "update accounts set discord_id = '$discord_id' where user_id = '$user_id' limit 1";
    mysqli_query($con, $query);
    $query = "update accounts set discord_avatar = '$discord_avatar' where user_id = '$user_id' limit 1";
    mysqli_query($con, $query);
}

if($_POST['save'] === "saveDiscord") {
    echo "SAVING DISCORD DATA";
    die;
}


if(empty($fullDiscordName)) {
    $discordName = "Discord not Connected";
} else {
    $splitVersion = explode("#", $fullDiscordName);
    $discordNameNumbers = '#';
    $discordNameNumbers .= $splitVersion[1];
    $discordName =  $splitVersion[0];
}
if(empty($user_data['discord_avatar'])) {
    $discord_Avatar_Image = "images/DiscordPoop.png";
} else {
    $discord_Avatar_Image = getDiscordImage();
}

function getDiscordImage() {
    global $user_data;
    $url="https://cdn.discordapp.com/avatars/"; 
    $url.= $user_data['discord_id']; 
    $url.="/"; 
    $url.= $user_data['discord_avatar']; 
    $url.=".png";
    return $url;
}


// if($_SERVER['REQUEST_METHOD'] == "POST") {
//     $discord_avatar = $_POST['avatar'];
//     $discord_user = $_POST['discord_user'];
//     $discord_id = $_POST['discord_id'];
//     $license_key = $_POST['license_key'];
//     $user_id = $user_data['user_id'];
    
//     $query = "update accounts set discord_username = '$discord_user' where user_id = '$user_id' limit 1";
//     mysqli_query($con, $query);
//     $query = "update accounts set discord_id = '$discord_id' where user_id = '$user_id' limit 1";
//     mysqli_query($con, $query);
//     $query = "update accounts set discord_avatar = '$discord_avatar' where user_id = '$user_id' limit 1";
//     mysqli_query($con, $query);
//     header("Refresh:0");
// }

?>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

        <link href="src/styles/main.css" rel="stylesheet" type="text/css">
        <link href="src/styles/header.css" rel="stylesheet" type="text/css">
        <link href="src/styles/BigTitle.css" rel="stylesheet" type="text/css">
        <script src="src/js/features.js"></script>
        <script src="src/js/Dashboard.js"></script>
        <link href="src/styles/dashboard.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <header>
            <img class="logo" src="images/LoginKudo.png" alt="logo">
            <nav>
                <ul class="navigation">
                </ul>
            </nav>
            <a class="sign_out">sign out</a>
        </header>
        <div class="box">
          
            <img id="discord_avatar" src=<?php echo $discord_Avatar_Image?> class="discord"></img>
            <a id="discord_Title">Discord Account</a>
            <a id="discord_username"><?php echo $discordName?>
                <span id="discord_numbers"><?php echo $discordNameNumbers?></span>
            </a>
            <button onclick="resetDiscordLogin()" id="signout_discord">disconnect</button> 
            <button onclick="redirectToDiscordOAuth()" id="login_discord">connect discord</button> 

            <form class="form" method="post">
                <input type="hidden" id="discord_user" name="discord_user" value="<?php echo $fullDiscordName;?>">
                <input type="hidden" id="discord_id" name="discord_id" value="<?php echo $discordId;?>">
                <input type="hidden" id="avatar" name="avatar" value="<?php echo $discordAvatar;?>">

                <div class="seperator"></div>

                <a class="license_key_title">License Key</a>
                <input id="license_key" value="<?php echo $license; ?>" readonly></input>
                <div class="seperator"></div>

                <input onclick="saveUnsavedChanges()" type="submit" id="save_changes" value="save"></input>
                <a id="changes">changes saved</a>
            </form>

            <form method="get" action="file.doc">
                <button type="submit">Download!</button>
            </form>
        </div>
    </body>
</html>