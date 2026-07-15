<?php
require_once __DIR__ . '/conexion.php';
$target = 'familiar/formulario.php';
if (!empty($_SERVER['QUERY_STRING'])) {
    $target .= '?' . $_SERVER['QUERY_STRING'];
}
header('Location: ' . $target);
exit;
?>