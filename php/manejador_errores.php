<?php

if (defined('NEARCARE_GLOBAL_ERROR_HANDLER')) {
    return;
}

define('NEARCARE_GLOBAL_ERROR_HANDLER', true);

ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

if (ob_get_level() === 0) {
    ob_start();
}

function mostrarPantallaError(
    string $mensaje = 'Ocurrió un problema inesperado. Inténtalo nuevamente.',
    string $volverA = 'javascript:history.back()',
    string $titulo = 'Algo no salió bien',
    int $codigoHttp = 400,
    string $accionSecundariaUrl = '/NearCare2/index.php',
    string $accionSecundariaTexto = 'Ir al inicio'
): void {
    if (!headers_sent()) {
        http_response_code($codigoHttp);
        header('Content-Type: text/html; charset=UTF-8');
    }

    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    $tituloSeguro = htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8');
    $mensajeSeguro = htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8');
    $volverSeguro = htmlspecialchars($volverA, ENT_QUOTES, 'UTF-8');
    $accionSecundariaUrlSegura = htmlspecialchars($accionSecundariaUrl, ENT_QUOTES, 'UTF-8');
    $accionSecundariaTextoSeguro = htmlspecialchars($accionSecundariaTexto, ENT_QUOTES, 'UTF-8');
    ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tituloSeguro; ?> | NearCare</title>
    <link rel="stylesheet" href="/NearCare2/Css/pantalla-error.css?v=1">
    <link rel="icon" type="image/png" sizes="32x32" href="/NearCare2/img/favicon_io%20%283%29/favicon-32x32.png">
</head>
<body class="error-page">
    <main class="error-card" role="alert" aria-live="assertive">
        <img class="error-logo" src="/NearCare2/img/Designer%20%2816%29.png" alt="NearCare">
        <div class="error-icon" aria-hidden="true">
            <svg width="38" height="38" viewBox="0 0 24 24">
                <path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm0 14.8a1.2 1.2 0 1 1 0 2.4 1.2 1.2 0 0 1 0-2.4ZM10.9 6h2.2v8h-2.2V6Z"/>
            </svg>
        </div>
        <p class="error-kicker">No te preocupes</p>
        <h1><?php echo $tituloSeguro; ?></h1>
        <p class="error-message"><?php echo $mensajeSeguro; ?></p>
        <p class="error-help">Revisa la información e inténtalo nuevamente.</p>
        <div class="error-actions">
            <a class="error-primary" href="<?php echo $volverSeguro; ?>">Volver e intentar de nuevo</a>
            <a class="error-secondary" href="<?php echo $accionSecundariaUrlSegura; ?>"><?php echo $accionSecundariaTextoSeguro; ?></a>
        </div>
    </main>
</body>
</html>
    <?php
    exit();
}

set_exception_handler(function (Throwable $error): void {
    error_log((string) $error);
    mostrarPantallaError(
        'No pudimos completar esta acción. Inténtalo nuevamente.',
        'javascript:history.back()',
        'Ocurrió un problema inesperado',
        500
    );
});

register_shutdown_function(function (): void {
    $error = error_get_last();
    $erroresFatales = [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR];

    if ($error === null || !in_array($error['type'], $erroresFatales, true)) {
        return;
    }

    error_log(sprintf(
        'Error fatal NearCare: %s en %s:%d',
        $error['message'],
        $error['file'],
        $error['line']
    ));

    mostrarPantallaError(
        'La página encontró un problema y no pudo terminar de cargar.',
        'javascript:location.reload()',
        'No pudimos cargar esta página',
        500
    );
});
