<?php
session_start();
include("conexion.php");

if (!isset($_GET['id'])) {
    http_response_code(400);
    exit("Audio no especificado");
}

$id_nota = (int)$_GET['id'];
$id_doctor = (int)($_SESSION['id_doctor'] ?? 0);
$id_paciente_familiar = (int)($_SESSION['paciente_id'] ?? 0);

if ($id_doctor <= 0 && $id_paciente_familiar <= 0) {
    http_response_code(403);
    exit("No autorizado");
}

$sql = "SELECT archivo_audio
        FROM notas_paciente
        WHERE id_nota = ?
          AND tipo = 'audio'
          AND (
              (id_doctor = ? AND ? > 0)
              OR (id_paciente = ? AND ? > 0)
          )
        LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "iiiii",
    $id_nota,
    $id_doctor,
    $id_doctor,
    $id_paciente_familiar,
    $id_paciente_familiar
);
$stmt->execute();
$nota = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$nota || empty($nota['archivo_audio'])) {
    http_response_code(404);
    exit("Audio no encontrado");
}

$rutaAudio = __DIR__ . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $nota['archivo_audio']);
$baseAudios = realpath(__DIR__ . DIRECTORY_SEPARATOR . 'audios');
$archivoReal = realpath($rutaAudio);

if (!$baseAudios || !$archivoReal || strpos($archivoReal, $baseAudios) !== 0 || !is_file($archivoReal)) {
    http_response_code(404);
    exit("Audio no encontrado");
}

header("Content-Type: audio/webm");
header("Content-Length: " . filesize($archivoReal));
header("Accept-Ranges: bytes");
readfile($archivoReal);
exit();
