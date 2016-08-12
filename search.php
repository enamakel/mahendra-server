<?php
header('Content-Type: application/json');
include_once('db_connect.php');


// Fetch all the leads for the current user.
$match = $_GET["match"];
$buffer = [];

// Execute the query
$q = "SELECT DISTINCT(user_id) FROM relations
    WHERE
        location_id in (select id from locations where name like '%$match%') OR
        job_role_id in (select id from job_roles where name like '%$match%') OR
        job_sector_id in (select id from job_sectors where name like '%$match%') OR
        product_channel_id in (select id from product_channels where name like '%$match%') OR
        product_name_id in (select id from product_names where name like '%$match%') OR
        service_name_id in (select id from service_names where name like '%$match%') OR
        service_occupation_id in (select id from service_occupations where name like '%$match%') OR
        user_id in (select id from login where name like '%$match%' OR phone like '%$match%' OR bizType like '%$match%')
    GROUP BY user_id
    LIMIT 25;

";
$result = $conn->query($q);

// Fetch all the data and return the results.
if ($result) {
    while ($duh = $result->fetch_assoc()) {
        $userId = $duh["user_id"];

        $q = "SELECT * FROM relations WHERE user_id='$userId'";
        $q2 = "SELECT * FROM login WHERE id='$userId';";

        $result3 = $conn->query($q2);
        $resp = $result3->fetch_assoc();

        $resp["locationsIds"] = [];
        $resp["jobRolesIds"] = [];
        $resp["jobSectorsIds"] = [];
        $resp["productChannelIds"] = [];
        $resp["productNameIds"] = [];
        $resp["serviceNamesIds"] = [];
        $resp["serviceOccupationIds"] = [];

        $result2 = $conn->query($q);
        while ($data = $result2->fetch_assoc()) {
            if (isset($data["location_id"])) $resp["locationsIds"][] = $data["location_id"];
            if (isset($data["job_role_id"])) $resp["jobRolesIds"][] = $data["job_role_id"];
            if (isset($data["job_sector_id"])) $resp["jobSectorsIds"][] = $data["job_sector_id"];
            if (isset($data["product_channel_id"])) $resp["productChannelIds"][] = $data["product_channel_id"];
            if (isset($data["product_name_id"])) $resp["productNameIds"][] = $data["product_name_id"];
            if (isset($data["service_name_id"])) $resp["serviceNamesIds"][] = $data["service_name_id"];
            if (isset($data["service_occupation_id"])) $resp["serviceOccupationIds"][] = $data["service_occupation_id"];
        }

        $duh["user"] = $resp;
        $buffer[] = $duh;
    }
    echo json_encode($buffer);
} else echo '[]';
