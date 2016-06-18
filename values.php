<?php
header('Content-Type: application/json');
include_once('db_connect.php');


function grabAll($table, $conn) {
    $buffer = [];
    $q = "SELECT * FROM $table;";
    $result = $conn->query($q);
    while ($data = $result->fetch_assoc()) { $buffer[] = $data; }
    return $buffer;
}


$data["service_names"] = grabAll("service_names", $conn);
$data["locations"] = grabAll("locations", $conn);
$data["job_sectors"] = grabAll("job_sectors", $conn);
$data["job_roles"] = grabAll("job_roles", $conn);
$data["service_occupations"] = grabAll("service_occupations", $conn);
$data["product_channels"] = grabAll("product_channels", $conn);
$data["product_names"] = grabAll("product_names", $conn);

echo json_encode($data);
