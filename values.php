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

$muffer = [];
$muffer["service_names"] = grabAll("service_names", $conn);
$muffer["locations"] = grabAll("locations", $conn);
$muffer["job_sectors"] = grabAll("job_sectors", $conn);
$muffer["job_roles"] = grabAll("job_roles", $conn);
$muffer["service_occupations"] = grabAll("service_occupations", $conn);
$muffer["product_channels"] = grabAll("product_channels", $conn);
$muffer["product_names"] = grabAll("product_names", $conn);

echo json_encode($muffer);
