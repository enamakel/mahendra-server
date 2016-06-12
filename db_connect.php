<?php

// $db_connect = mysql_connect('localhost','root', '');
$conn = mysqli_connect("localhost", "root", "", "mahendra");

if (!$conn) {
    die('Connection unsuccessful:
        ' . mysqli_connect_errno());
    }
