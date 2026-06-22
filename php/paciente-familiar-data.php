<?php
session_start();
require_once __DIR__ . '/../doctor/conexion.php';

$isLoggedIn = isset($_SESSION['usuario_id']);
$idDoctor = (int)($_GET['id_doctor'] ?? 0);
$nc = trim($_GET['nc'] ?? '');
$nc = preg_replace('/^nc\s*/i', '', $nc);
$paciente = null;
$mensaje = '';

$conn->set_charset("utf8mb4");

if ($nc === '') {
    $mensaje = 'Ingresa el codigo Nc del paciente.';

} else {
    // Especificamos "familiares.pacientes" para que SQL cambie de base de datos automáticamente
    $sql = "SELECT p.*, d.nombre AS doctor_nombre
            FROM familiares.pacientes p
            INNER JOIN nearcare.doctores d ON d.id_doctor = p.id_doctor
            WHERE p.nc = ?";

// ... Tu código siguiente se queda igual ...

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

