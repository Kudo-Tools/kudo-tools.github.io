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
        $query = $con->prepare("SELECT * FROM messages");
        $query->execute();
        $items = $query->fetchAll();

        $saved_announcements = "";
        $saved_authors = "";
        $saved_times = "";

        $totalData = array();
        foreach($items as $row) {
            $data = [
                "message" => str_replace('"', "", $row['body']),
                "title" => str_replace('"', "", $row['title']),
                "timestamp" => str_replace('"', "", $row['timestamp']),
            ];
            array_push($totalData, $data);
        }
        
        header('Content-Type: application/json');
        echo json_encode($totalData);
        die;
    } else {
        echo "No License Key Provided";
        die;
    }
} else {
    echo "No Parameters Provided";
    die;
}

?>