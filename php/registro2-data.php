<?php
session_start();
require_once __DIR__ . '/saludo.php';

$nombre = $_SESSION['registro_nombre'] ?? $_SESSION['usuario'] ?? 'usuario';
$correo = $_SESSION['correo'] ?? '';
$saludo = nearcare_saludo($nombre);

?>

