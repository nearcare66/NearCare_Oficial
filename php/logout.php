<?php
session_start();
require_once __DIR__ . '/../conexion.php';
session_destroy();

header("Location: ../index.php");
exit();
?>
