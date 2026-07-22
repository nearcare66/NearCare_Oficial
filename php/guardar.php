<?php
session_start();

include("../conexion.php");

$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$codigo = trim($_POST['codigo'] ?? '');

if ($nombre === '' || $correo === '' || $codigo === '') {
    mostrarPantallaError(
        'Todos los campos son obligatorios.',
        '../register.php',
        'Faltan datos por completar'
    );
}

$stmt = $conexion->prepare("INSERT INTO usuarios_nuevos(nombre, correo, codigo) VALUES (?, ?, ?)");

if (!$stmt) {
    error_log('Error al preparar registro familiar: ' . $conexion->error);
    mostrarPantallaError(
        'No pudimos preparar el registro. Inténtalo nuevamente.',
        '../register.php',
        'No se pudo completar el registro',
        500
    );
}

$stmt->bind_param("sss", $nombre, $correo, $codigo);

if ($stmt->execute()) {
    header("Location: ../familiar/loging.php");
    exit();
}

if ($stmt->errno === 1062) {
    error_log('Intento de registro familiar con correo duplicado: ' . $correo);
    $stmt->close();
    $conexion->close();

    mostrarPantallaError(
        'El correo ' . $correo . ' ya pertenece a una cuenta. Puedes iniciar sesión o registrarte con otro correo.',
        '../familiar/register.php',
        'Este correo ya está registrado',
        409,
        '../familiar/loging.php',
        'Ir a iniciar sesión'
    );
}

error_log('Error al guardar familiar: ' . $stmt->error);
mostrarPantallaError(
    'No pudimos guardar la información. Verifica los datos e inténtalo nuevamente.',
    '../register.php',
    'No se pudo completar el registro',
    500
);

$stmt->close();
$conexion->close();
?>
