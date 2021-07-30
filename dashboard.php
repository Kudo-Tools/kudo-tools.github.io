<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();
$_SESSION;

require("functions/connection.php");
require("functions/methods.php");
require("functions/discordToken.php");

//if logged in this contains user info
$con = establish_connection();

$user_data = check_login($con, true);
$con = null;

$fullDiscordName = $user_data['discord_username'];
$license = $user_data['license_key'];
$discordId = $user_data['discord_id'];
$discordAvatar = $user_data['discord_avatar'];
$discord_Avatar_Image = '';
$discordName = '';
$discordNameNumbers = '';

$matchFound = (array_key_exists("code", $_GET));
if($matchFound) {
    $json = getAccessToken();
    $discordName = $json['username'];
    $discordNameNumbers = $json['numbers'];
    $discordAvatar = $json['avatar'];
    $discordId = $json['id'];
    $fullDiscordName = $discordName . '#' .$discordNameNumbers;
    saveToDB($fullDiscordName, $discordId, $discordAvatar, $_SESSION["user_id"]);
    ?>
    <style>
        #discord_connect_button {
            display: block;
        }
        #discord_disconnect_button {
            display: block;
        }
    </style>
    <?php
}


$date_values = explode("-", $user_data['date']);
$year = $date_values[0];
$month = $date_values[1];
$day = explode(" ", $date_values[2])[0];
$date = $month . "/" . $day . "/" . $year;
$instances = $user_data["instances"];
$account_type = $user_data['account_type'];
$saved_announcements = "";
$saved_authors = "";
$saved_times = "";

// if($_SERVER['REQUEST_METHOD'] == "GET") {
// if(isset($_GET["get"])) {
$con = establish_connection();
$query = $con->prepare("SELECT * FROM messages");
$query->execute();
$items = $query->fetchAll();

foreach($items as $row) {
    $saved_announcements .= str_replace('"', "", $row['body']) . "{NEW MESSAGE}";
    $saved_authors  .= str_replace('"', "", $row['title']) . "{NEW AUTHOR}";
    $saved_times    .= str_replace('"', "", $row['timestamp']) . "{NEW TIME}";
}
$con = null;
function saveToDB($username, $id, $avatar, $user_id) {
    $con = establish_connection();
    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $query = $con->prepare("UPDATE accounts SET 
        discord_username = :username, 
        discord_id = :discId, 
        discord_avatar = :discAvatar
        WHERE user_id = :userId LIMIT 1");
    $result = $query->execute(
        array(
            ":username" => $username,
            ":discId" => $id,
            ":discAvatar" => $avatar,
            ":userId"=> $user_id
        )
    );
    header("Location: dashboard");
}
if($_SERVER['REQUEST_METHOD'] == "POST") {
    if(isset($_POST['disconnect'])) {
        saveToDB("", "", "", $_SESSION["user_id"]);
        ?>
        <style>
            #discord_connect_button {
                display: block;
            }
            #discord_disconnect_button {
                display: none;
            }
        </style>
        <?php
    }
}

if(empty($fullDiscordName)) {
    $discordName = "";
    $discordNameNumbers = "Not Connected";
    ?>
    <style>
        #discord_connect_button {
            display: block;
        }
        #discord_disconnect_button {
            display: none;
        }
    </style>
    <?php
} else {
    $splitVersion = explode("#", $fullDiscordName);
    $discordNameNumbers = '#';
    $discordNameNumbers .= $splitVersion[1];
    $discordName =  $splitVersion[0];
    ?>
    <style>
        #discord_connect_button {
            display: none;
        }
        #discord_disconnect_button {
            display: block;
        }
    </style>
    <?php
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

        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
    </head>
    <body>
        <header>
            <img onclick="window.location='https://www.kudotools.com/'" class="logo" src="images/LoginKudo.png" alt="logo">
            <nav>
                <ul class="navigation">
                </ul>
            </nav>
            <a class="sign_out">sign out</a>
        </header>
        <input type="hidden" id="announcement_news" value="<?php echo $saved_announcements;?>">
        <input type="hidden" id="announcement_author" value="<?php echo $saved_authors;?>">
        <input type="hidden" id="announcement_time" value="<?php echo $saved_times;?>">
    
        <div class="wrapper">
            <div class="box">
                <div class="left_side">
                    <div class="section welcome">
                        <a>Welcome back, User</a>
                        <br>
                        <br>
                        <p>member since</p>
                        <p><?php echo $date; ?></p>
                    </div>
                    <div class="horizontal_seperator"></div>
                    <div class="section discord">
                        <a>Discord Account</a>
                        <!-- <form class="form" method="post"> -->
                            <!-- <input type="hidden" id="discord" value="<?php echo $saved_announcements;?>">
                            <input type="hidden" id="" value="<?php echo $saved_authors;?>">
                            <input type="hidden" id="" value="<?php echo $saved_times;?>"> -->
    

                        <button onclick="redirectToDiscordOAuth()" id="discord_connect_button">connect</button>
                        <form method="post">
                            <button name="disconnect" id="discord_disconnect_button">disconnect</button>
                        </form>
                        <br>
                        <div class="discord_container">
                            <img id="discord_avatar" src=<?php echo $discord_Avatar_Image?>></img>
                            <a id="discord_username"><?php echo $discordName?>
                                <!-- <span id="discord_numbers"></span> -->
                                <span id="discord_numbers"><?php echo $discordNameNumbers?></span>
                            </a>
                        </div>
                    </div>
                    <div class="horizontal_seperator"></div>
                    <div class="section license">
                        <a>License Key</a>
                        <div class="license_container">
                            <a id="license_key" ><?php echo $license; ?></a>
                            <!-- <div class="copy">copy</div> -->
                        </div>
                        
                    </div>
                </div>
                <div class="vertical_seperator"></div>
                <div class="right_side">
                    <div class="section instances">
                        <a>Instances</a>
                        <p id="running_instances"><?php echo $instances . " Available" ?></p>
                    </div>
                    <div class="horizontal_seperator"></div>
                    <div class="section discord_server">
                        <a>Discord Server</a>
                        <p id="join_discord">join discord server</p>
                    </div>
                    <div class="horizontal_seperator"></div>
                    <div class="section license_type">
                        <a>License Type</a>
                        <p id="account_type"><?php echo $account_type; ?></p>
                    </div>
                </div>
                
                
            </div>
            <div id="announcement" class="infobox">
                <div style="background: transparent;">
                    <a onclick="getAnnouncementInformation()" class="info_title">Announcements</a>
                </div>
            </div>
            <div id="release_notes" class="infobox">
                <div style="background: transparent;">
                    <a class="info_title">Release Notes</a>
                </div>
            </div>
            <div class="download">
                <h1 class="download_title">Windows download</h1>
                <div class="windows">
                    <img class="icon" src="images/windows.png" alt="logo">
            
                </div>
            </div>
            <!-- <div class="save_container">
                <p id="changes">changes saved</p>
                <form class="form" method="post">
                    <input type="hidden" name="discord_id" id="discord_id" value="<?php echo $discordId;?>">
                    <input type="hidden" name="discord_avatar" id="discord_avatar" value="<?php echo $discordAvatar;?>">
                    <input type="hidden" name="discord_username" id="discord_username" value="<?php echo $fullDiscordName;?>">
                    <input onclick="setChangesSaved()" class="save_button" type="submit" value="save" name="save">
                </form>
            </div> -->
            
            <!-- <div class="download_wrapper"> -->
                
            <!-- </div> -->
        </div>
        
    </body>
</html>