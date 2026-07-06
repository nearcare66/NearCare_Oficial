<?php
require_once __DIR__ . "/../conexion.php";

if (!isset($conexion)) {
    echo "no_connection";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "invalid_method";
    $conexion->close();
    exit;
}

$comentario = trim($_POST["comentario"] ?? "");

if ($comentario === "") {
    echo "empty";
    $conexion->close();
    exit;
}

$stmt = $conexion->prepare("INSERT INTO comentarios (comentario) VALUES (?)");

if (!$stmt) {
    echo "error_prepare";
    $conexion->close();
    exit;
}

$stmt->bind_param("s", $comentario);
echo $stmt->execute() ? "ok" : "error_sql";

$stmt->close();
$conexion->close();
?>
