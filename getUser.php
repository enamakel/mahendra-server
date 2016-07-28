<?php
header('Content-Type: application/json');
include_once('db_connect.php');

$password = mysqli_real_escape_string($conn, $_REQUEST['password']);

$q = "
    SELECT * FROM login
        WHERE password='$password'
    LIMIT 1;
";

$result = $conn->query($q);

if ($result->num_rows > 0) $resp = $result->fetch_assoc();
else {
    $resp = array('message' => 'user_doesnt_exist');
    http_response_code(400);
}

echo json_encode($resp);
