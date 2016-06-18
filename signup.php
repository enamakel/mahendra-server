<?php
header('Content-Type: application/json');
include_once('db_connect.php');


$name = mysqli_real_escape_string($conn, $_POST['name']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$location_id = mysqli_real_escape_string($conn, $_POST['location_id']);
$bizType = mysqli_real_escape_string($conn, $_POST['bizType']);

$q = "SELECT * FROM login WHERE phone='$phone' LIMIT 1";
$result = $conn->query($q);

if ($result->num_rows > 0) {
    $resp = array('message' => 'error_exists');
    http_response_code(400);

} else {
    $query="
        INSERT INTO login SET
            name='$name',
            phone='$phone',
            bizType='$bizType',
            location_id='$location_id',
            password='$password',";


    if (isset($_POST["job_sector_id"])) {
        $val = $_POST["job_sector_id"];
        $vals[] = "job_sector_id='$val'";
    }

    if (isset($_POST["job_role_id"])) {
        $val = $_POST["job_role_id"];
        $vals[] = "job_role_id='$val'";
    }

    if (isset($_POST["service_occupation_id"])) {
        $val = $_POST["service_occupation_id"];
        $vals[] = "service_occupation_id='$val'";
    }

    if (isset($_POST["service_name_id"])) {
        $val = $_POST["service_name_id"];
        $vals[] = "service_name_id='$val'";
    }

    if (isset($_POST["product_channel_id"])) {
        $val = $_POST["product_channel_id"];
        $vals[] = "product_channel_id='$val'";
    }

    if (isset($_POST["product_name_id"])) {
        $val = $_POST["product_name_id"];
        $vals[] = "product_name_id='$val'";
    }

    $query .= join($vals, ", ") . ";";

    $conn->query($query);
    $resp = array('message' => 'saved');
}

echo json_encode($resp);
