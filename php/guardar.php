<?php
session_start();

include("../conexion.php");

$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$codigo = trim($_POST['codigo'] ?? '');

if ($nombre === '' || $correo === '' || $codigo === '') {
    echo "Todos los campos son obligatorios";
    exit();
}

$stmt = $conexion->prepare("INSERT INTO usuarios_nuevos(nombre, correo, codigo) VALUES (?, ?, ?)");

if (!$stmt) {
    die("Error en prepare: " . $conexion->error);
}

$stmt->bind_param("sss", $nombre, $correo, $codigo);

if ($stmt->execute()) {
    header("Location: ../loging.php");
    exit();
}

echo "Error al guardar: " . $stmt->error;

$stmt->close();
$conexion->close();
?>
