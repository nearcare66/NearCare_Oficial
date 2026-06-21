<?php
include("conexion.php");

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$especialidad = $_POST['especialidad'];
$telefono = $_POST['telefono'];

$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO doctores(nombre, correo, password, especialidad, telefono)
VALUES ('$nombre', '$correo', '$password', '$especialidad', '$telefono')";

if ($conn->query($sql) === TRUE) {
    echo "Doctor registrado correctamente";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>