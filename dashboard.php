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
$con = null;


$fullDiscordName = $user_data['discord_username'];
$license = $user_data['license_key'];
$discordId = $user_data['discord_id'];
$discordAvatar = $user_data['discord_avatar'];
$discord_Avatar_Image = '';
$discordName = '';
$discordNameNumbers = '';


// $con = establish_connection();
// $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
// $conn = establish_connection();
// $query = "select title from messages";
// $result = mysqli_query($conn, $query);

// if(mysqli_num_rows($result) > 0) {
    // while($row = mysqli_fetch_assoc($result)) {
        // $saved_messages .= $row['body'] . "{NEW MESSAGE}";
        // $saved_authors .= $row['title'] . "{NEW AUTHOR}";
        // $saved_times .= $row['timestamp'] . "{NEW TIME}";
        // echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    // }
// }
// mysqli_close($conn);


// for($x = 0; $x < count($items); $x++) {
//     $message = $messages[$x];
//     $author = $auhtors[$x];
//     $time = $times[$x];
//     $saved_messages .= $message . "{NEW MESSAGE}";
//     $saved_authors .= $author . "{NEW AUTHOR}";
//     $saved_times .= $time . "{NEW TIME}";
// }
// echo json_encode(array(
//     "messages"=>$messages
// ));

// try {
    // $discordToAdd = htmlspecialchars($_GET["code"]);
    // if(!empty($discordToAdd)) {
    //     // updateDiscordInformation();
    //     // header("Location: dashboard");
    //     echo "DISCORD IS SUPPOSE TO BE ADDED";
    //     die;
    // }
// } catch (exception $e) {}

// function updateDiscordInformation() {
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
// }
$messages_for_announcements = "";
$saved_authors = "";
$saved_times = "";

// if($_SERVER['REQUEST_METHOD'] == "GET") {
    // if(isset($_GET["get"])) {
$con = establish_connection();
$query = $con->prepare("SELECT * FROM messages");
$query->execute();
$items = $query->fetchAll();

foreach($items as $row) {
    $messages_for_announcements .= $row['body'] . "{NEW MESSAGE}";
    $saved_authors  .= $row['title'] . "{NEW AUTHOR}";
    $saved_times    .= $row['timestamp'] . "{NEW TIME}";
}
echo "IN ITS ENTIRETY = ";
echo $messages_for_announcements;
echo "-----------------------------------------------------------------";
$con = null;
    // }
    // echo "failed info";
    // die;
// }
if($_SERVER['REQUEST_METHOD'] == "POST") {
    if(isset($_POST["save"])) {

    }
    $discord_avatar = $_POST['avatar'];
    $discord_user = $_POST['discord_user'];
    $discord_id = $_POST['discord_id'];
    $user_id = $user_data['user_id'];
    $con = establish_connection();
    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $query = $con->prepare("update accounts set discord_username = :username where user_id = :userId limit 1");
    // $query->bindParam(
        
    // );
    $result = $query->execute(
        array(
            ":username" => $discord_user,
            ":userId"=> $user_id
        )
    );
    // echo "COMPLETETLY GOOD";
    // die;
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
        <input type="hidden" id="announcement_news" value="<?php echo $messages_for_announcements;?>">
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
                        <p>05/03/2020</p>
                    </div>
                    <div class="horizontal_seperator"></div>
                    <div class="section discord">
                        <a>Discord Account</a>
                        <button id="discord_connect_button">connect</button>
                        <button id="discord_disconnect_button">disconnect</button>
                        <br>
                        <div class="discord_container">
                            <img id="discord_avatar" src="images/DiscordPoop.png"></img>
                            <a id="discord_username">Teeds
                                <!-- <span id="discord_numbers"><?php echo $discordNameNumbers?></span> -->
                                <span id="discord_numbers">#6855</span>
                            </a>
                        </div>
                        
                    </div>
                    <div class="horizontal_seperator"></div>
                    <div class="section license">
                        <a>License Key</a>
                        <div class="license_container">
                            <a id="license_key" >Kudo-ABCD-EFGH-IJKLM</a>
                            <!-- <div class="copy">copy</div> -->
                        </div>
                        
                    </div>
                </div>
                <div class="vertical_seperator"></div>
                <div class="right_side">
                    <div class="section instances">
                        <a>Instances</a>
                        <p id="running_instances">0 / 2 Running</p>
                    </div>
                    <div class="horizontal_seperator"></div>
                    <div class="section discord_server">
                        <a>Discord Server</a>
                        <p id="join_discord">join discord server</p>
                    </div>
                    <div class="horizontal_seperator"></div>
                    <div class="section license_type">
                        <a>License Type</a>
                        <p id="account_type">trial</p>
                    </div>
                </div>
                
                <!-- <img id="discord_avatar" src=<?php echo $discord_Avatar_Image?> class="discord"></img> -->
                
                <!-- <a id="discord_Title">Discord Account</a> -->
                <!-- <a id="discord_username"><?php echo $discordName?> -->
                
                <!-- <button onclick="resetDiscordLogin()" id="signout_discord">disconnect</button> 
                <button onclick="redirectToDiscordOAuth()" id="login_discord">connect discord</button>  -->
    
                <form class="form" method="post">
                    <!-- <input type="hidden" id="discord_user" name="discord_user" value="<?php echo $fullDiscordName;?>">
                    <input type="hidden" id="discord_id" name="discord_id" value="<?php echo $discordId;?>">
                    <input type="hidden" id="avatar" name="avatar" value="<?php echo $discordAvatar;?>"> -->
    
                    <!-- <div class="seperator"></div> -->
    
                    <!-- <a class="license_key_title">License Key</a> -->
                    <!-- <input id="license_key" value="<?php echo $license; ?>" readonly></input> -->
                    <!-- <input id="license_key" value="Kudo-ABCD-EFGH-IJKLM" readonly></input> -->
                    <!-- <div class="seperator"></div> -->
    
                    <!-- <input onclick="saveUnsavedChanges()" type="submit" id="save_changes" value="save"></input> -->
                    <!-- <a id="changes">changes saved</a> -->
                </form>
    
                <!-- <form method="get" action="file.doc">
                    <button type="submit">Download!</button>
                </form> -->
                
            </div>
            <div id="announcement" class="infobox">
                <div style="background: transparent;">
                    <a onclick="getAnnouncementInformation()" class="info_title">Announcements</a>
                </div>
            </div>
            <div class="infobox">
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
            <form class="form" method="get">
                <input type="submit" value="refresh" name="refresh">
            </form>
            <form class="form" method="post">

                <input type="submit" value="save" name="save">
            </form>
            <!-- <div class="download_wrapper"> -->
                
            <!-- </div> -->
        </div>
        
    </body>
</html>