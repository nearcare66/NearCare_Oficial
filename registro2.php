<?php
require_once __DIR__ . '/conexion.php';
$target = 'familiar/registro2.php';
if (!empty($_SERVER['QUERY_STRING'])) {
    $target .= '?' . $_SERVER['QUERY_STRING'];
}
header('Location: ' . $target);
exit;
?>