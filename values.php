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

function grabAllFromParent($table, $subTable, $conn) {
    $buffer = [];

    $q = "SELECT * FROM $table;";
    $result = $conn->query($q);

    while ($data = $result->fetch_assoc()) {
        $id = $data['id'];
        $buffer2 = [];

        $q = "SELECT * FROM $subTable WHERE parent_id=$id;";
        $result2 = $conn->query($q);

        while ($data2 = $result2->fetch_assoc()) { $buffer2[] = $data2; }

        $data["children"] = $buffer2;
        $buffer[] = $data;
    }
    return $buffer;
}

$muffer = [];

$muffer["locations"] = grabAll("locations", $conn);
$muffer["business_types"] = grabAll("business_types", $conn);
$muffer["job_sectors"] = grabAllFromParent("job_sectors", "job_roles", $conn);
$muffer["service_occupations"] = grabAllFromParent("service_occupations", "service_names", $conn);
$muffer["product_channels"] = grabAllFromParent("product_channels", "product_names", $conn);

echo json_encode($muffer);
