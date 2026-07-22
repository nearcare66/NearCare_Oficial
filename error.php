<?php

$codigo = (int) ($_GET['codigo'] ?? http_response_code());

if ($codigo === 404) {
    mostrarPantallaError(
        'La página que buscas no existe o fue movida.',
        '/NearCare2/index.php',
        'Página no encontrada',
        404
    );
}

mostrarPantallaError(
    'El servidor no pudo completar la solicitud en este momento.',
    'javascript:location.reload()',
    'Servicio temporalmente no disponible',
    500
);

