<?php

// Use this file to manage job postings

include_once('db_connect.php');


if (isset($_GET['add']) ) {    
    $creator_id = mysqli_real_escape_string($conn, $_GET['creator_id']);
    $need = mysqli_real_escape_string($conn, $_GET['need']);
    $job = mysqli_real_escape_string($conn, $_GET['job']);
    $description = mysqli_real_escape_string($conn, $_GET['description']);
    $location_id = mysqli_real_escape_string($conn, $_GET['location_id']);
        
    $query='
        INSERT INTO 
        jobs
        SET
            creator_id="'.$creator_id.'",
            need="'.$need.'",
            job="'.$job.'",
            description="'.$description.'",
            location_id="'.$location_id.'"
    ;';

    $conn->query($query);
    
    $resp = 'data_saved';


} else if (isset($_GET['get']) ) {    
    $query='SELECT * FROM jobs WHERE';

    if (isset($_GET['need'])) {
        $need = mysqli_real_escape_string($conn, $_GET['need']);
        $query .= " need='$need'";
    }

    if (isset($_GET['job'])) {
        if (isset($_GET['need'])) $query .= " AND ";

        $job = mysqli_real_escape_string($conn, $_GET['job']);
        $query .= " job='$job'";
    }

    if (isset($_GET['location_id'])) {
        if (isset($_GET['job'])) $query .= " AND ";

        $location_id = mysqli_real_escape_string($conn, $_GET['location_id']);
        $query .= " location_id='$location_id'";
    }

    $query .= ';';

    $resp = array();

    if ($result = $conn->query($query)) {
        while($job = $result->fetch_assoc()) {
            $resp[] = $job;
        }
    }
    
} else $resp = 'not found';


echo json_encode($resp);
