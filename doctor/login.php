<?php
session_start();
include("conexion.php");

if (isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login-form.php");
    exit();
}

$correo = trim($_POST['correo'] ?? '');
$password = $_POST['password'] ?? '';

$_SESSION['doctor_login_correo'] = $correo;

if ($correo === '' || $password === '') {
    $_SESSION['doctor_login_error'] = "Correo o contraseña de doctor incorrectos.";
    header("Location: login-form.php");
    exit();
}

$stmt = $conn->prepare("SELECT id_doctor, nombre, password FROM doctores WHERE correo = ?");

if (!$stmt) {
    error_log('Error al preparar acceso de doctor: ' . $conn->error);
    mostrarPantallaError(
        'No pudimos procesar el inicio de sesión en este momento.',
        'login-form.php',
        'No se pudo iniciar sesión',
        500
    );
}

$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $doctor = $result->fetch_assoc();

    if (password_verify($password, $doctor['password'])) {
        $_SESSION['id_doctor'] = $doctor['id_doctor'];
        $_SESSION['nombre'] = $doctor['nombre'];
        unset($_SESSION['doctor_login_error'], $_SESSION['doctor_login_correo']);

        header("Location: dashboard.php");
        exit();
    }
}

$_SESSION['doctor_login_error'] = "Correo o contraseña de doctor incorrectos.";
header("Location: login-form.php");
exit();
?>
