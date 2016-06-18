<?php
header('Content-Type: application/json');
include_once('db_connect.php');

$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$q = "
    SELECT * FROM login
        WHERE phone='$phone' AND password='$password'
    LIMIT 1;
";

$result = $conn->query($q);

if ($result->num_rows > 0) $resp = $result->fetch_assoc();
else {
    $resp = array('message' => 'error_login');
    http_response_code(400);
}


echo json_encode($resp);
