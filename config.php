<?php 

$server = "localhost";
$username = "root";
$password = "";
$database = "pendaftaran_siswa";

// Create connection
$conn = new mysqli($server, $username, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}


?>