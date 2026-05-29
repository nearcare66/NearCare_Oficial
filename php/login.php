<?php

session_start();

$conexion = new mysqli("localhost", "root", "", "familiares");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$nombre = $_POST['nombre'] ?? '';
$codigo = $_POST['codigo'] ?? '';

if (empty($nombre) || empty($codigo)) {
    echo "Campos vacíos";
    exit;
}

$stmt = $conexion->prepare("SELECT * FROM usuarios_nuevos WHERE nombre = ? AND codigo = ?");

if (!$stmt) {
    die("Error en prepare: " . $conexion->error);
}

$stmt->bind_param("ss", $nombre, $codigo);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {


    $_SESSION['usuario'] = $nombre;

    header("Location: ../index.php");
    exit();

} else {
    echo "ID o contraseña incorrectos";
}

$stmt->close();
$conexion->close();
?>