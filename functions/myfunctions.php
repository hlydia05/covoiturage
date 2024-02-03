<?php

@include '../config.php';

function getAll($table){
    global $conn;
    $query = "select * from $table";
    $query_run = mysqli_query($conn, $query);
    return $query_run;
}

function redirect($url, $message){
    $_SESSION['message']=$message;
    header('location:'.$url);
    exit();
}


function getCurrentNumber($table){
    global $conn;
    $current_query = "SELECT COUNT(*) AS count FROM $table";
    $current_query_run = mysqli_query($conn, $current_query);
    $row = mysqli_fetch_assoc($current_query_run);
    return $row['count'];
}

function getPrevNumber($table){
    global $conn;
    $prev_query = "SELECT COUNT(*) AS count FROM $table WHERE DATE(created_at) BETWEEN DATE_SUB(CURDATE(), INTERVAL 2 MONTH) AND DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
    $prev_query_run = mysqli_query($conn, $prev_query);
    $row = mysqli_fetch_assoc($prev_query_run);
    return $row['count'];
}


?>
