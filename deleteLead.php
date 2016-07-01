<?php
header('Content-Type: application/json');
include_once('db_connect.php');


// Fetch all the leads for the current user.
$leadId = $_GET["lead_id"];
$buffer = [];

// Execute the query
$q = "UPDATE leads SET is_deleted = 1 WHERE id='$leadId'";

$conn->query($q);


echo json_encode(array('status' => 'done'));
