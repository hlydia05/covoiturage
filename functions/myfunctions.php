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


function getNumber($table){
    global $conn;
    $nbrquery = "SELECT count(*) FROM $table";
    $nbrquery_run = mysqli_query($conn, $nbrquery);
    return $nbrquery_run;
}


?>