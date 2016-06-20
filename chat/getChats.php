<?php
header('Content-Type: application/json');
include_once('../db_connect.php');


// Fetch all the leads for the current user.
$userId = $_GET["user_id"];
$vals = [];
$buffer = [];

// Get the user first by user id
$q = "
    SELECT DISTINCT m.proposal_id FROM messages as m
    WHERE (m.user_id = $userId) OR ($userId in (
            SELECT DISTINCT p.engaging_user_id FROM proposals as p WHERE m.proposal_id = p.id
        )
    )
;
";

$result = $conn->query($q);

if ($result) {
    while ($data = $result->fetch_assoc()) $buffer[] = $data["proposal_id"];
    echo json_encode($buffer);
} else echo "[]";

