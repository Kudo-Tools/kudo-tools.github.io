<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
$registration = $_POST['registration'];
$name= $_POST['user'];
$email= $_POST['id'];
$email= $_POST['avatar'];
if ($registration == "success"){
    // some action goes here under php
    echo json_encode(array(
        "abc"=>'successfuly registered'
    ));
    die;
}  
?>