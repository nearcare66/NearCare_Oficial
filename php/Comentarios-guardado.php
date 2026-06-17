<?php
require_once(__DIR__ . "/../conexion.php"); // ✅ CORRECTO FINAL

if (!isset($conexion)) {
    echo "no_connection";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["comentario"])) {

        $comentario = trim($_POST["comentario"]);

        if (!empty($comentario)) {

            $stmt = $conexion->prepare("INSERT INTO comentarios (comentario) VALUES (?)");

            if (!$stmt) {
                echo "error_prepare";
                exit;
            }

            $stmt->bind_param("s", $comentario);

            if ($stmt->execute()) {
                echo "ok";
            } else {
                echo "error_sql";
            }

            $stmt->close();

        } else {
            echo "empty";
        }

    } else {
        echo "no_data";
    }
}

$conexion->close();
?>