<?php

// file to send a message from the user

include_once('../db_connect.php');
header('Content-Type: application/json');

$user_id = $_REQUEST["user_id"];
$message = $_REQUEST["text"];
$chat_id = $_REQUEST["chat_id"];

$query="INSERT INTO messages
    SET
        text='$message',
        chat_id='$chat_id',
        user_id='$user_id';";


$result = $conn->query($query);

echo json_encode(array('status' => 'done'));
