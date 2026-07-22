<?php
session_start();
include("conexion.php");

if(isset($_SESSION['usuario_id'])){
    header("Location: ../index.php");
    exit();
}

$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$especialidad = trim($_POST['especialidad'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$passwordPlano = $_POST['password'] ?? '';

if ($nombre === '' || $correo === '' || $especialidad === '' || $telefono === '' || $passwordPlano === '') {
    mostrarPantallaError(
        'Completa todos los datos solicitados para crear la cuenta.',
        'register-form.php',
        'Faltan datos por completar'
    );
}

$password = password_hash($passwordPlano, PASSWORD_DEFAULT);

$stmt = $conn->prepare(
    'INSERT INTO doctores (nombre, correo, password, especialidad, telefono) VALUES (?, ?, ?, ?, ?)'
);

if (!$stmt) {
    error_log('Error al preparar registro de doctor: ' . $conn->error);
    mostrarPantallaError(
        'No pudimos preparar el registro. Inténtalo nuevamente.',
        'register-form.php',
        'No se pudo completar el registro',
        500
    );
}

$stmt->bind_param('sssss', $nombre, $correo, $password, $especialidad, $telefono);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    header('Location: login-form.php?registro=exitoso');
    exit();
}

$numeroError = $stmt->errno;
$detalleError = $stmt->error;
$stmt->close();
$conn->close();

if ($numeroError === 1062) {
    mostrarPantallaError(
        'El correo ' . $correo . ' ya pertenece a una cuenta de doctor. Puedes iniciar sesión o usar otro correo.',
        'register-form.php',
        'Este correo ya está registrado',
        409,
        'login-form.php',
        'Ir a iniciar sesión'
    );
}

error_log('Error al registrar doctor: ' . $detalleError);
mostrarPantallaError(
    'No pudimos crear la cuenta. Verifica la información e inténtalo nuevamente.',
    'register-form.php',
    'No se pudo completar el registro',
    500
);
?>
