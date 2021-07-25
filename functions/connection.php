<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
function establish_connection() {
    echo "creating connection | ";
    $dbhost = "us-cdbr-east-03.cleardb.com";
    $dbuser = "b2335803e8210c";
    $dbpassword = "2670080a";
    $dbname = "heroku_7cc8cb2939f8da4";
    // $con = new PDO($dbhost, $dbuser, $dbpassword, $dbname);
    $con = new PDO("mysql:host=".$dbhost.";dbname=".$dbname."", $dbuser, $dbpassword);
    
    if(!$con) {
        echo "Failure to connect to database";
        die("failure to connect");
    }
    return $con;
}
// function establish_mysqli_connection() {
//     $dbhost = "us-cdbr-east-03.cleardb.com";
//     $dbuser = "b2335803e8210c";
//     $dbpassword = "2670080a";
//     $dbname = "heroku_7cc8cb2939f8da4";
//     $conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
//     return $conn;
// }

// $cleardb_url = parse_url(getenv("mysql://ba72f7c647a318:d4b5f181@us-cdbr-east-03.cleardb.com/heroku_4f443fd1ef6d8c0?reconnect=true"));
// $cleardb_server = $cleardb_url["us-cdbr-east-03.cleardb.com"];
// $cleardb_username = $cleardb_url["ba72f7c647a318"];
// $cleardb_password = $cleardb_url["d4b5f181"];
// $cleardb_db = substr($cleardb_url["path"],1);
// $active_group = 'default';
// $query_builder = TRUE;
// Connect to DB
// echo $cleardb_url["host"];
// $con = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

?>