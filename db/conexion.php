<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Futcol";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_errno) {
    die("Conexión fallida: " . $conn->connect_error);
}


?>


