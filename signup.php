<?php
header('Content-Type: application/json');
include_once('db_connect.php');

$data = json_decode(file_get_contents('php://input'), true);

$name = mysqli_real_escape_string($conn, $data['name']);
$phone = mysqli_real_escape_string($conn, $data['phone']);
$password = mysqli_real_escape_string($conn, $data['password']);
$bizType = mysqli_real_escape_string($conn, $data['bizType']);

$query = "SELECT * FROM login
    WHERE
        password='$password'
    LIMIT 1;";
$result = $conn->query($query);


function addRelation($userId, $key, $value, $conn) {
    $query="INSERT INTO relations SET user_id='$userId', $key='$value';";
    $conn->query($query);
}


function processArray($userId, $arr, $dbKey, $conn) {
    foreach ($arr as $value) addRelation($userId, $dbKey, $value, $conn);
}


if ($result->num_rows > 0) {
    $resp = $result->fetch_assoc();
    // $resp = array('message' => 'error_exists');
    http_response_code(400);

} else {
    $query="INSERT INTO login
        SET
            name='$name',
            phone='$phone',
            bizType='$bizType',
            password='$password';";


    $result = $conn->query($query);
    $newUserId = mysqli_insert_id($conn);

    processArray($newUserId, $data["locationsIds"], "location_id", $conn);

    processArray($newUserId, $data["jobRolesIds"], "job_role_id", $conn);
    processArray($newUserId, $data["jobSectorsIds"], "job_sector_id", $conn);

    processArray($newUserId, $data["productChannelIds"], "product_channel_id", $conn);
    processArray($newUserId, $data["productNameIds"], "product_name_id", $conn);

    processArray($newUserId, $data["serviceNamesIds"], "service_name_id", $conn);
    processArray($newUserId, $data["serviceOccupationIds"], "service_occupation_id", $conn);

    $query = "
        SELECT * FROM login
            WHERE id='$newUserId'
        LIMIT 1;
    ";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $resp = $result->fetch_assoc();
    } else $resp = array('message' => 'not saved');
}

echo json_encode($resp);
