<?php
header('Content-Type: application/json');
include_once('db_connect.php');

$password = mysqli_real_escape_string($conn, $_POST['password']);

$q = "
    SELECT * FROM login
        WHERE password='$password'
    LIMIT 1;
";

$result = $conn->query($q);

if ($result->num_rows > 0) {
    $resp = $result->fetch_assoc();
    $userId = $resp["id"];

    $q = "
        SELECT * FROM relations
            WHERE user_id='$userId'
    ";

    $resp["locationsIds"] = [];
    $resp["jobRolesIds"] = [];
    $resp["jobSectorsIds"] = [];
    $resp["productChannelIds"] = [];
    $resp["productNameIds"] = [];
    $resp["serviceNamesIds"] = [];
    $resp["serviceOccupationIds"] = [];

    $result = $conn->query($q);
    while ($data = $result->fetch_assoc()) {
        if (isset($data["location_id"])) $resp["locationsIds"][] = $data["location_id"];
        if (isset($data["job_role_id"])) $resp["jobRolesIds"][] = $data["job_role_id"];
        if (isset($data["job_sector_id"])) $resp["jobSectorsIds"][] = $data["job_sector_id"];
        if (isset($data["product_channel_id"])) $resp["productChannelIds"][] = $data["product_channel_id"];
        if (isset($data["product_name_id"])) $resp["productNameIds"][] = $data["product_name_id"];
        if (isset($data["service_name_id"])) $resp["serviceNamesIds"][] = $data["service_name_id"];
        if (isset($data["service_occupation_id"])) $resp["serviceOccupationIds"][] = $data["service_occupation_id"];
    }
}
else {
    $resp = array('message' => 'error_login');
    http_response_code(400);
}


echo json_encode($resp);
