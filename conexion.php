<?php

$host = "localhost";
$usuario = "root";
$password = "";
$database = "nearcare"; 

$conn = mysqli_connect($host, $usuario, $password, $database);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

?>