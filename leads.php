<?php
header('Content-Type: application/json');
include_once('db_connect.php');

/* Use this file to get the leads for the current user */


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // If we are submitting a new lead, details go in here.

} else {
    // Fetch all the leads for the current user.
    $userId = $_GET["userid"];
    $vals = [];
    $buffer = [];

    // Get the user first by user id
    $q = "SELECT * FROM login WHERE id='$userId';";
    $result = $conn->query($q);
    $user = $result->fetch_assoc();

    // Start preparing the query for the leads
    $q = "SELECT * FROM leads WHERE creator_id!='$userId' ";

    if (isset($_GET["job_seeker"])) {
        $val = $_GET["job_seeker"] ? 1 : 0;
        $vals[] = "is_job_seeker='$val'";
    } else if (isset($_GET["service_seeker"])) {
        $val = $_GET["service_seeker"] ? 1 : 0;
        $vals[] = "is_service_seeker='$val'";
    } else if (isset($_GET["product_seeker"])) {
        $val = $_GET["product_seeker"] ? 1 : 0;
        $vals[] = "is_product_seeker='$val'";
    }

    if (isset($user["job_sector_id"])) {
        $val = $user["job_sector_id"];
        $vals[] = "job_sector_id='$val'";
    }

    if (isset($user["job_role_id"])) {
        $val = $user["job_role_id"];
        $vals[] = "job_role_id='$val'";
    }

    if (isset($user["service_occupation_id"])) {
        $val = $user["service_occupation_id"];
        $vals[] = "service_occupation_id='$val'";
    }

    if (isset($user["service_name_id"])) {
        $val = $user["service_name_id"];
        $vals[] = "service_name_id='$val'";
    }

    if (isset($user["product_channel_id"])) {
        $val = $user["product_channel_id"];
        $vals[] = "product_channel_id='$val'";
    }

    if (isset($user["product_name_id"])) {
        $val = $user["product_name_id"];
        $vals[] = "product_name_id='$val'";
    }

    if (isset($user["location_id"])) {
        $val = $user["location_id"];
        $vals[] = "location_id='$val'";
    }

    if (count($vals) > 0) $q .= "AND " . join($vals, " AND ");

    // Sort by date created
    $q .= " ORDER BY created_at DESC";

    // Execute the query!
    $result = $conn->query($q);

    // Fetch all the data and return the results.
    if ($result) {
        while ($data = $result->fetch_assoc()) { $buffer[] = $data; }
        echo json_encode($buffer);
    } else echo '[]';
}
