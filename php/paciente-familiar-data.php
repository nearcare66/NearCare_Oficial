<?php
session_start();
require_once __DIR__ . '/../doctor/conexion.php';

$isLoggedIn = isset($_SESSION['usuario_id']);
$idDoctor = (int)($_GET['id_doctor'] ?? 0);
$nc = trim($_GET['nc'] ?? ($_SESSION['paciente_nc'] ?? ''));
$nc = preg_replace('/^nc\s*/i', '', $nc);
$paciente = null;
$mensaje = '';

$conn->set_charset("utf8mb4");

if ($nc === '') {
    $mensaje = 'Ingresa el codigo Nc del paciente.';
} else {
    $sql = "SELECT p.*, d.nombre AS doctor_nombre
            FROM pacientes p
            INNER JOIN doctores d ON d.id_doctor = p.id_doctor
            WHERE p.nc = ?";

    if ($idDoctor > 0) {
        $sql .= " AND p.id_doctor = ?";
    }

    $sql .= " LIMIT 1";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        if ($idDoctor > 0) {
            $stmt->bind_param("si", $nc, $idDoctor);
        } else {
            $stmt->bind_param("s", $nc);
        }

        $stmt->execute();
        $resultado = $stmt->get_result();
        $paciente = $resultado->fetch_assoc();
        $stmt->close();
    }

    if (!$paciente) {
        $mensaje = 'No se encontro un paciente con ese codigo Nc.';
        unset($_SESSION['paciente_id'], $_SESSION['paciente_nc'], $_SESSION['paciente_nombre']);
    } else {
        $_SESSION['paciente_id'] = (int)$paciente['id_paciente'];
        $_SESSION['paciente_nc'] = $paciente['nc'];
        $_SESSION['paciente_nombre'] = $paciente['nombre_completo'];
    }
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function fechaPartes($fecha) {
    $timestamp = strtotime($fecha);

    if (!$timestamp) {
        return ['-', '-', '-'];
    }

    return [date('j', $timestamp), date('n', $timestamp), date('Y', $timestamp)];
}

[$diaIngreso, $mesIngreso, $anioIngreso] = $paciente ? fechaPartes($paciente['fecha_ingreso']) : ['-', '-', '-'];
$fotoPaciente = $paciente && !empty($paciente['foto']) ? "img/" . $paciente['foto'] : "img/Designer (16).png";

?>

