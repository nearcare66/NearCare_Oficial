<?php
include("conexion.php");

$correo = $_POST['correo'];
$password = $_POST['password'];

$sql = "SELECT * FROM doctores WHERE correo='$correo'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $doctor = $result->fetch_assoc();

    if (password_verify($password, $doctor['password'])) {

        session_start();

        $_SESSION['id_doctor'] = $doctor['id_doctor'];
        $_SESSION['nombre'] = $doctor['nombre'];

        header("Location: dashboard.php");

    } else {
        echo "Contraseña incorrecta";
    }

} else {
    echo "Correo no encontrado";
}

$conn->close();
?>