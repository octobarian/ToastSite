<?php
$servername = "35.226.50.204";
$dBUsername = "root";
$dBPassword = "saitamaiscool";
$dBName = "travel";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if(!$conn){
    die("Connection Failed: ".mysqli_connect_error());
}