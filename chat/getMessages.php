<?php

// file to send a message from the user

include_once('../db_connect.php');
header('Content-Type: application/json');

$chat_id = $_REQUEST["chat_id"];

$query="SELECT * FROM messages
    WHERE
        chat_id='$chat_id'";


$result = $conn->query($query);

$buffer = [];
while ($data = $result->fetch_assoc()) {
    $reciever_id = $data["user_id"];
    $q = "SELECT * FROM login WHERE id='$reciever_id';";
    $result2 = $conn->query($q);
    $data["user"] = $result2->fetch_assoc();

    // $sender_id = $data["sender_id"];
    // $q = "SELECT * FROM login WHERE id='$sender_id';";
    // $result2 = $conn->query($q);
    // $data["sender"] = $result2->fetch_assoc();

    $buffer[] = $data;
}
echo json_encode($buffer);
