<?php
header('Content-Type: application/json');
include_once('db_connect.php');

$data = json_decode(file_get_contents('php://input'), true);

$name = mysqli_real_escape_string($conn, $data['name']);
$phone = mysqli_real_escape_string($conn, $data['phone']);
$password = mysqli_real_escape_string($conn, $data['password']);
$bizType = mysqli_real_escape_string($conn, $data['bizType']);

$q = "SELECT * FROM login WHERE phone='$phone' LIMIT 1";
$result = $conn->query($q);

function addRelation($userId, $key, $value, $conn) {
    $query="INSERT INTO relations SET user_id='$userId', $key='$value';";
    $conn->query($query);
}

function processArray($userId, $arr, $dbKey, $conn) {
    foreach ($arr as $value) addRelation($userId, $dbKey, $value, $conn);
}


if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $userId = $user["id"];

    $query="DELETE FROM relations where user_id='$userId';";
    $result = $conn->query($query);

    $query="UPDATE login SET name='$name' WHERE id='$userId'";
    $result = $conn->query($query);

    processArray($userId, $data["locationsIds"], "location_id", $conn);

    processArray($userId, $data["jobRolesIds"], "job_role_id", $conn);
    processArray($userId, $data["jobSectorsIds"], "job_sector_id", $conn);

    processArray($userId, $data["productChannelIds"], "product_channel_id", $conn);
    processArray($userId, $data["productNameIds"], "product_name_id", $conn);

    processArray($userId, $data["serviceNamesIds"], "service_name_id", $conn);
    processArray($userId, $data["serviceOccupationIds"], "service_occupation_id", $conn);

    $resp = array('message' => 'saved');
} else {
    $resp = array('message' => 'not_found');
    http_response_code(400);
}

echo json_encode($resp);
