<?php

$conn = mysqli_connect('localhost','root','','covoiturage');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>