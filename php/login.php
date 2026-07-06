<?php
session_start();

include("../conexion.php");

$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$codigo = trim($_POST['codigo'] ?? '');

$_SESSION['familiar_login_nombre'] = $nombre;
$_SESSION['familiar_login_correo'] = $correo;

if ($nombre === '' || $correo === '' || $codigo === '') {
    $_SESSION['familiar_login_error'] = "Nombre, correo o codigo de familiar incorrectos.";
    header("Location: ../loging.php");
    exit();
}

$stmt = $conexion->prepare("SELECT id, nombre, correo FROM usuarios_nuevos WHERE nombre = ? AND correo = ? AND codigo = ?");

if (!$stmt) {
    die("Error en prepare: " . $conexion->error);
}

$stmt->bind_param("sss", $nombre, $correo, $codigo);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();

    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario'] = $usuario['nombre'];
    $_SESSION['correo'] = $usuario['correo'];
    $_SESSION['registro_nombre'] = $usuario['nombre'];
    unset($_SESSION['familiar_login_error'], $_SESSION['familiar_login_nombre'], $_SESSION['familiar_login_correo']);

    header("Location: ../registro2.php");
    exit();
}

$_SESSION['familiar_login_error'] = "Nombre, correo o codigo de familiar incorrectos.";
header("Location: ../loging.php");
exit();
?>
