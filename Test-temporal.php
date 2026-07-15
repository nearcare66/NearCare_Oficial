<?php
require_once __DIR__ . '/conexion.php';
$target = 'familiar/Test-temporal.php';
if (!empty($_SERVER['QUERY_STRING'])) {
    $target .= '?' . $_SERVER['QUERY_STRING'];
}
header('Location: ' . $target);
exit;
?>