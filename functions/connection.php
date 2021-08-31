<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
function establish_connection() {
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

?>
