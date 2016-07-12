<?php
header('Content-Type: application/json');
include_once('db_connect.php');

// Use this file to get the proposals for the current user

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // If we are submitting a new proposal, details go in here.
    $userId = $_POST["user_id"];
    $leadId = $_POST["lead_id"];

    $q = "INSERT INTO proposals SET
        engaging_user_id='$userId',
        lead_id='$leadId';
    ";

    $conn->query($q);
    echo json_encode(array('message' => 'saved'));

} else {
    // Fetch all the leads for the current user.
    // $userId = $_GET["user_id"];
    $leadId = $_GET["lead_id"];
    $vals = [];
    $buffer = [];

    // Get the user first by user id
    // $q = "SELECT * FROM login WHERE id='$userId';";
    // $result = $conn->query($q);
    // $user = $result->fetch_assoc();

    // Start preparing the query for the leads
    $q = "SELECT * from proposals WHERE lead_id = '$leadId'
        ORDER BY created_at DESC;";
    // $q = "SELECT * from proposals WHERE lead_id in (
    //     SELECT id FROM leads WHERE creator_id = '$userId'
    // ) ORDER BY created_at DESC;";

    // Execute the query!
    $result = $conn->query($q);

    // Fetch all the data and return the results.
    if ($result) {
        while ($data = $result->fetch_assoc()) {
            // Fetch and attach the user
            $engaging_user_id = $data["engaging_user_id"];
            $q = "SELECT * FROM login WHERE id='$engaging_user_id';";
            $result = $conn->query($q);
            $data["user"] = $result->fetch_assoc();

            // Fetch and attach the lead
            $lead = $data["lead_id"];
            $q = "SELECT * FROM leads WHERE id='$lead';";
            $result = $conn->query($q);
            $data["lead"] = $result->fetch_assoc();

            $buffer[] = $data;
        }
        echo json_encode($buffer);
    } else echo '[]';
}
