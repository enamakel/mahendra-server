<?php
include_once('config.php');
header('Content-Type: application/json');

$proposal_id = $_GET["proposal_id"];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = "SELECT u.name, m.text FROM
        messages as m
            JOIN
        login as u
        WHERE
            u.id = m.user_id AND
            m.proposal_id = $proposal_id
        ORDER BY  m.id";

	$stmt = $conn->prepare($sql);
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);


		  $resultSet['result'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		 //print_r($resultSet);
		  $resultSet['status']="True";
		  $resultSet['count']=$stmt->rowCount();
		echo json_encode($resultSet);
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

?>
