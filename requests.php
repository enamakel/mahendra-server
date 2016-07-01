<?php
header('Content-Type: application/json');
include_once('db_connect.php');

/* Use this file to get the leads made by current user */


// Fetch all the leads for the current user.
$userId = $_GET["user_id"];
$buffer = [];

// Execute the query
$q = "SELECT * FROM leads WHERE creator_id='$userId' AND is_deleted = 0 ORDER BY created_at DESC";
$result = $conn->query($q);

// Fetch all the data and return the results.
if ($result) {
    while ($data = $result->fetch_assoc()) { $buffer[] = $data; }
    echo json_encode($buffer);
} else echo '[]';
