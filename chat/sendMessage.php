<?php
include_once('config.php');
header('Content-Type: application/json');
if (isset($_REQUEST["uid"]) && $_REQUEST["uid"]!="" && isset($_REQUEST["message"]) && $_REQUEST["message"]!="" ) {
    $uid = $_REQUEST["uid"];
    $message = $_REQUEST["message"];
    $proposal_id = $_REQUEST["proposal_id"];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
	 $sqlInsert = "INSERT INTO messages (user_id, text, proposal_id)
    VALUES ('".$uid."', '".$message."', ' ".$proposal_id."')";
    // use exec() because no results are returned
	$stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->execute();
	$output['status']= "new";
	$output['uid']= $uid;
	$output['message']= $message;
	echo json_encode($output);
   // echo "New record created successfully ".$nickname;
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

/**
 * Registering a user device
 * Store reg id in users table
 */

} else {
    // user details missing
	$output['msg'] = "uid or message is missing";
	$output['status'] = "false";
	echo json_encode($output);
}
?>
