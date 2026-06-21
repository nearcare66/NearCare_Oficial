<?php

$host = "localhost";
$usuario = "root";
$password = "";
$database = "nearcare";

$conn = new mysqli($host, $usuario, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

?>