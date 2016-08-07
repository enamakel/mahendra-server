<?php

// file to send a message from the user

include_once('../db_connect.php');
header('Content-Type: application/json');

$user_id = $_REQUEST["user_id"];

$query="SELECT * FROM chats
    WHERE
        user_id_a='$user_id' OR user_id_b='$user_id'
        ORDER BY id DESC";


$result = $conn->query($query);

$buffer = [];
while ($data = $result->fetch_assoc()) {
    $reciever_id = $data["user_id_a"];
    $q = "SELECT * FROM login WHERE id='$reciever_id';";
    $result2 = $conn->query($q);
    $data["user_a"] = $result2->fetch_assoc();

    $sender_id = $data["user_id_b"];
    $q = "SELECT * FROM login WHERE id='$sender_id';";
    $result2 = $conn->query($q);
    $data["user_b"] = $result2->fetch_assoc();

    $proposal_id = $data["proposal_id"];
    $q = "SELECT * FROM proposals WHERE id='$proposal_id';";
    $result2 = $conn->query($q);
    $data["proposal"] = $result2->fetch_assoc();

    $buffer[] = $data;
}
echo json_encode($buffer);
