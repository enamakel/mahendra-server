<?php

include_once('db_connect.php');

if ( ($_GET['email'])!="" && isset($_GET['signin']) ) {
    
    $name = mysqli_real_escape_string($conn, $_GET['name']);
    $email = mysqli_real_escape_string($conn, $_GET['email']);
    $phone = mysqli_real_escape_string($conn, $_GET['phone']);
    $password = mysqli_real_escape_string($conn, $_GET['password']);
    $job = mysqli_real_escape_string($conn, $_GET['job']);
    $occupation = mysqli_real_escape_string($conn, $_GET['occupation']);
    $location_id = mysqli_real_escape_string($conn, $_GET['location_id']);
    $bizType = mysqli_real_escape_string($conn, $_GET['bizType']);
    
    $q='select * from login
        where email="'.$email.'" 
        limit 1';
    $result = $conn->query($q);

    if ($result->num_rows > 0) {
        $resp ='error_exists';
        http_response_code(400);
    } else {                    
        $query="
            INSERT INTO login SET
                name='$name',
                email='$email',
                phone='$phone',
                job='$job',
                occupation='$occupation',
                bizType='$bizType',
                location_id='$location_id',
                password='$password';";

        $conn->query($query);
        $resp = 'data_saved';
    } 
    
}

if ( ($_GET['password'])!="" && ($_GET['email'])!="" && isset($_GET['login']) ) {
    $email = mysqli_real_escape_string($conn, $_GET['email']);
    $password = mysqli_real_escape_string($conn, $_GET['password']);
    
    $q = "
        SELECT * FROM login
            WHERE email='$email' AND password='$password' 
        LIMIT 1;
    ";
    
    $result = $conn->query($q);

    if ($result->num_rows > 0) {
        // $resp 
        $resp = $result->fetch_assoc();   
    } else {  
        $resp ='error_login';
        http_response_code(400);
    }
}

// if ( ($_GET['email'])!="" && isset($_GET['forget']) )
// {
//     $email = mysqli_real_escape_string($conn, $_GET['email']);
    
//     $q='select * from login
//         where email="'.$email.'" 
//         limit 1';
//     $result = mysql_query($q);
//     if (mysql_num_rows($result)>0)
//     {
//         while( $row=mysql_fetch_object( $result ) )
//                 {
//                     $resp ='success_forget';
//                     mail($row->email, 'Your name(password)', 'Your name(password):'.$row->name);
//                 }
        
//     }else{
//         $resp ='error_forget';
//     }   
// }

echo json_encode($resp);
?>
