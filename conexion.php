<?php
require_once __DIR__ . '/php/manejador_errores.php';

$conexion = new mysqli("localhost", "root", "", "familiares");

if ($conexion->connect_error) {
    error_log('Error de conexión familiares: ' . $conexion->connect_error);
    mostrarPantallaError(
        'No pudimos conectarnos al sistema en este momento. Inténtalo nuevamente en unos minutos.',
        'javascript:location.reload()',
        'Servicio temporalmente no disponible',
        500
    );
}

$conexion->set_charset("utf8mb4");
?>
