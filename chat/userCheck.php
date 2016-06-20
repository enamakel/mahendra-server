<?php
include_once('config.php');
header('Content-Type: application/json');
if (isset($_REQUEST["deviceId"]) && $_REQUEST["deviceId"]!="") {
    $deviceId = $_REQUEST["deviceId"];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  $sql = "select * from user where deviceid= '".$deviceId."' limit 1";
	$stmt = $conn->prepare($sql);
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
	if($stmt->rowCount()<=0) {

		$sqlCount = "select * from user";
		$stmtCount = $conn->prepare($sqlCount);
		$stmtCount->execute();

		$nickname= 'user'.str_pad($stmtCount->rowCount()+1, 8, "0", STR_PAD_LEFT);
	 $sqlInsert = "INSERT INTO user (nickname, deviceid)
    VALUES ('".$nickname."', '".$deviceId."')";
    // use exec() because no results are returned
	$stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->execute();
	$lastId = $conn->lastInsertId();
	$output['status']= "new";
	$output['nickname']= $nickname;
	$output['deviceid']= $deviceId;
	$output['uid']= $lastId ;
	echo json_encode($output);
   // echo "New record created successfully ".$nickname;

	} else {
		 $resultSet = $stmt->fetch(PDO::FETCH_ASSOC);
		  $resultSet['status']="True";
		echo json_encode($resultSet);

	}

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
	$output['msg'] = "Please send device id";
	$output['status'] = "false";
	echo json_encode($output);
}
?>
