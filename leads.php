<?php
header('Content-Type: application/json');
include_once('db_connect.php');

/* Use this file to get the leads for the current user */

function checkAndSet($key, $arr) {
    // var_dump(isset($_POST[$key]));
    if (isset($_POST[$key])) {
        $val = $_POST[$key];
        $arr[] = "$key='$val'";
    }

    return $arr;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // If we are submitting a new lead, details go in here.
    $vals = [];

    $q = "INSERT INTO leads SET ";

    $vals = checkAndSet("creator_id", $vals);
    $vals = checkAndSet("description", $vals);
    $vals = checkAndSet("job_sector_id", $vals);
    $vals = checkAndSet("job_role_id", $vals);
    $vals = checkAndSet("is_job_seeker", $vals);
    $vals = checkAndSet("service_occupation_id", $vals);
    $vals = checkAndSet("service_name_id", $vals);
    $vals = checkAndSet("is_service_seeker", $vals);
    $vals = checkAndSet("product_name_id", $vals);
    $vals = checkAndSet("product_channel_id", $vals);
    $vals = checkAndSet("is_product_seeker", $vals);
    $vals = checkAndSet("location_id", $vals);

    $q .= join($vals, ", ") . ";";

    $conn->query($q);
    $resp = array('message' => 'saved');
    echo json_encode($resp);

} else {
    // Fetch all the leads for the current user.
    $userId = $_GET["user_id"];
    $vals = [];
    $buffer = [];

    // Get the user first by user id
    $q = "SELECT * FROM login WHERE id='$userId';";
    $result = $conn->query($q);
    $user = $result->fetch_assoc();

    // Start preparing the query for the leads
    $q = "SELECT * FROM leads WHERE creator_id!='$userId' ";

    $getJobs = true;
    $getServices = true;
    $getProducts = true;

    if (isset($_GET["no_jobs"])) {
        $getJobs = $_GET["no_jobs"] ? false : true;
    } else if (isset($_GET["no_services"])) {
        $getServices = $_GET["no_services"] ? false : true;
    } else if (isset($_GET["no_products"])) {
        $getProducts = $_GET["no_products"] ? false : true;
    }

    if (isset($_GET["job_seeker"]) && $getJobs) {
        $val = $_GET["job_seeker"] ? 1 : 0;
        $vals[] = "is_job_seeker='$val'";
    } else if (isset($_GET["service_seeker"]) && $getServices) {
        $val = $_GET["service_seeker"] ? 1 : 0;
        $vals[] = "is_service_seeker='$val'";
    } else if (isset($_GET["product_seeker"]) && $getProducts) {
        $val = $_GET["product_seeker"] ? 1 : 0;
        $vals[] = "is_product_seeker='$val'";
    }

    $requests = [];

    if ($getJobs) {
        if (isset($user["job_sector_id"])) {
            $val = $user["job_sector_id"];
            $vals[] = "job_sector_id='$val'";
        }

        if (isset($user["job_role_id"])) {
            $val = $user["job_role_id"];
            $vals[] = "job_role_id='$val'";
        }
    } else {
        $vals[] = "job_sector_id=null";
        $vals[] = "job_role_id=null";
    }

    if (count($vals) > 0) $requests[] = join($vals, " AND ");
    $vals = [];


    if ($getServices) {
        if (isset($user["service_occupation_id"]) && $getServices) {
            $val = $user["service_occupation_id"];
            $vals[] = "service_occupation_id='$val'";
        }

        if (isset($user["service_name_id"]) && $getServices) {
            $val = $user["service_name_id"];
            $vals[] = "service_name_id='$val'";
        }
    } else {
        $vals[] = "service_occupation_id=null";
        $vals[] = "service_name_id=null";
    }

    if (count($vals) > 0) $requests[] = join($vals, " AND ");
    $vals = [];

    if ($getProducts) {
        if (isset($user["product_channel_id"]) && $getProducts) {
            $val = $user["product_channel_id"];
            $vals[] = "product_channel_id='$val'";
        }

        if (isset($user["product_name_id"]) && $getProducts) {
            $val = $user["product_name_id"];
            $vals[] = "product_name_id='$val'";
        }
    } else {
        $vals[] = "job_sector_id=null";
        $vals[] = "job_role_id=null";
    }

    if (count($vals) > 0) $requests[] = join($vals, " AND ");
    $vals = [];

    if (isset($user["location_id"])) {
        $val = $user["location_id"];
        $vals[] = "location_id='$val'";
    }

    if (count($vals) > 0) $q .= "AND (" . join($requests, ") OR (") . ")";

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
