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

function pickAndSetArray($key, $relation, $result) {
    if(isset($relation[$key])) {
        if(!isset($result[$key])) $result[$key] = [];
        $result[$key][] = $relation[$key];
    }

    return $result;
}


function createStatement($userRelations, $key) {
        $subVal = [];

        if (isset($userRelations[$key]) && count($userRelations[$key]) > 0) {
            $subVal = join($userRelations[$key], ", ");
            return "$key in ($subVal)";
        }

        return "$key=null";
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
    $userRelations = [];

    // Get the user first by user id
    $q = "SELECT * FROM login WHERE id='$userId';";
    $result = $conn->query($q);
    $user = $result->fetch_assoc();

    $q = "SELECT * FROM relations WHERE user_id='$userId';";
    $result = $conn->query($q);
    while ($data = $result->fetch_assoc()) { $userRelations[] = $data; }

    foreach ($userRelations as $relation) {
        $buffer = pickAndSetArray("job_sector_id", $relation, $buffer);
        $buffer = pickAndSetArray("job_role_id", $relation, $buffer);
        $buffer = pickAndSetArray("service_occupation_id", $relation, $buffer);
        $buffer = pickAndSetArray("service_name_id", $relation, $buffer);
        $buffer = pickAndSetArray("product_channel_id", $relation, $buffer);
        $buffer = pickAndSetArray("product_name_id", $relation, $buffer);
        $buffer = pickAndSetArray("location_id", $relation, $buffer);
    }
    $userRelations = $buffer;
    $buffer = [];

    // Start preparing the query for the leads
    $q = "SELECT * FROM leads WHERE creator_id!='$userId' AND is_deleted = 0 ";

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


    if ($getJobs) {
        if (isset($_GET["job_seeker"])) {
            $val = $_GET["job_seeker"] ? 1 : 0;
            $buffer[] = "is_job_seeker='$val'";
        }

        $buffer[] = createStatement($userRelations, "job_sector_id");
        $buffer[] = createStatement($userRelations, "job_role_id");
    } else {
        $buffer[] = "job_sector_id=null";
        $buffer[] = "job_role_id=null";
    }
    if (count($buffer) > 0) $requests[] = join($buffer, " AND ");
    $buffer = [];


    if ($getServices) {
        if (isset($_GET["service_seeker"])) {
            $val = $_GET["service_seeker"] ? 1 : 0;
            $buffer[] = "is_service_seeker='$val'";
        }

        $buffer[] = createStatement($userRelations, "service_occupation_id");
        $buffer[] = createStatement($userRelations, "service_name_id");
    } else {
        $vals[] = "service_occupation_id=null";
        $vals[] = "service_name_id=null";
    }
    if (count($buffer) > 0) $requests[] = join($buffer, " AND ");
    $buffer = [];


    if ($getProducts) {
        if (isset($_GET["product_seeker"])) {
            $val = $_GET["product_seeker"] ? 1 : 0;
            $buffer[] = "is_product_seeker='$val'";
        }

        $buffer[] = createStatement($userRelations, "product_channel_id");
        $buffer[] = createStatement($userRelations, "product_name_id");
    } else {
        $vals[] = "product_channel_id=null";
        $vals[] = "product_name_id=null";
    }
    if (count($buffer) > 0) $requests[] = join($buffer, " AND ");
    $buffer = [];


    if (count($requests) > 0) $q .= "AND ((" . join($requests, ") OR (") . ")";

    $q .= ") AND " . createStatement($userRelations, "location_id");

    // Sort by date created
    $q .= " ORDER BY created_at DESC";

    // Execute the query!
    $result = $conn->query($q);

    // Fetch all the data and return the results.
    if ($result) {
        while ($data = $result->fetch_assoc()) {
            $userId = $data["creator_id"];
            $q = "SELECT * FROM login WHERE id='$userId';";
            $result2 = $conn->query($q);
            $data["creator"] = $result2->fetch_assoc();

            $buffer[] = $data;
        }
        echo json_encode($buffer);
    } else echo '[]';
}
