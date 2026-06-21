<?php
session_start();

$nombre = $_SESSION['registro_nombre'] ?? $_SESSION['usuario'] ?? 'usuario';
$correo = $_SESSION['correo'] ?? '';

?>

