<?php
session_start();

include("../conexion.php");

$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$codigo = trim($_POST['codigo'] ?? '');

$_SESSION['familiar_login_nombre'] = $nombre;
$_SESSION['familiar_login_correo'] = $correo;

if ($nombre === '' || $correo === '' || $codigo === '') {
    $_SESSION['familiar_login_error'] = "Nombre, correo o código de familiar incorrectos.";
    header("Location: ../loging.php");
    exit();
}

$stmt = $conexion->prepare("SELECT id, nombre, correo FROM usuarios_nuevos WHERE nombre = ? AND correo = ? AND codigo = ?");

if (!$stmt) {
    error_log('Error al preparar acceso familiar: ' . $conexion->error);
    mostrarPantallaError(
        'No pudimos procesar el inicio de sesión en este momento.',
        '../loging.php',
        'No se pudo iniciar sesión',
        500
    );
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

    header("Location: ../familiar/registro2.php");
    exit();
}

$_SESSION['familiar_login_error'] = "Nombre, correo o código de familiar incorrectos.";
header("Location: ../loging.php");
exit();
?>
