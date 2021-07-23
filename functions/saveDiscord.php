<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();
$_SESSION;
require("functions/connection.php");
require("functions/methods.php");

$registration = $_POST['registration'];

?>
        <script>
            console.log("outside function");
        </script>
    <?php

if ($registration == "success"){

    ?>
        <script>
            console.log("inside function");
        </script>
    <?php
    
    $username= $_POST['user'];
    $id= $_POST['id'];
    $avatar= $_POST['avatar'];
    $user_id = $user_data['user_id'];

    ?>
        <script>
            console.log("starting connection");
        </script>
    <?php

    $con = establish_connection();
    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $query = $con->prepare("update accounts set 
        discord_username = '$discord_user',
        discord_id = '$user_id',
        discord_avatar = '$avatar'
    where user_id = '$user_id' limit 1");
    $query->bindParam(":key", $key);

    ?>
        <script>
            console.log("sending connection");
        </script>
    <?php

    $result = $query->execute();

    ?>
        <script>
            console.log("getting result");
        </script>
    <?php

    if($result) {
        echo json_encode(array("abc"=>'successfuly registered'));
    } else {
        echo json_encode(array("abc"=>'failed change'));
    }

    ?>
        <script>
            console.log("done function");
        </script>
    <?php

    die;
    // $query = "update accounts set discord_username = '$discord_user' where user_id = '$user_id' limit 1";
    // mysqli_query($con, $query);
    // $query = "update accounts set discord_id = '$discord_id' where user_id = '$user_id' limit 1";
    // mysqli_query($con, $query);
    // $query = "update accounts set discord_avatar = '$discord_avatar' where user_id = '$user_id' limit 1";
    // mysqli_query($con, $query);
}  