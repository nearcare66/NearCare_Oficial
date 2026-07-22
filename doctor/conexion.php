<?php

require_once __DIR__ . '/pantalla_error.php';

$host = "localhost";
$usuario = "root";
$password = "";
$database = "nearcare";

$conn = new mysqli($host, $usuario, $password, $database);

if ($conn->connect_error) {
    mostrarPantallaError(
        'No pudimos conectarnos al sistema en este momento. Inténtalo nuevamente en unos minutos.',
        'javascript:location.reload()',
        'Servicio temporalmente no disponible'
    );
}

?>
