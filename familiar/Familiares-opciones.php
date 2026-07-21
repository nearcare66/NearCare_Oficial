<?php
session_start();
require_once __DIR__ . '/../php/saludo.php';
$isLoggedIn = isset($_SESSION['usuario_id']);
$saludo = nearcare_saludo($_SESSION['usuario'] ?? $_SESSION['registro_nombre'] ?? '');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>NearCare</title>
    <link rel="stylesheet" href="../Css/styles4.css">
    <link rel="stylesheet" href="../Css/session-menu.css">
  <link rel="stylesheet" href="../Css/botones-globales.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../Css/dark-mode.css?v=1">
  <script src="../dark-mode.js" defer></script>
    <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon_io%20%283%29/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon_io%20%283%29/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon_io%20%283%29/favicon-16x16.png">
    <link rel="shortcut icon" href="../img/favicon_io%20%283%29/favicon.ico">
    <link rel="manifest" href="../img/favicon_io%20%283%29/site.webmanifest">
</head>
<body>

<header class="navbar">
    
<div class="circle-big"></div>
<div class="circle-small"></div>
<div class="circle-right"></div>
<div class="circle-corner"></div>

    <div class="left">
        <?php if ($isLoggedIn): ?>
            <button class="menu-icon" type="button" aria-label="Abrir menu" aria-controls="sideMenu" aria-expanded="false">
                &#9776;
            </button>
        <?php endif; ?>
        <span class="back">&#8249;</span>
        <img src="../img/Designer (16).png" class="logo" alt="NearCare">
    </div>

    <div class="right">
        <div class="avatar"></div>
        <span class="bienvenido"><?php echo $saludo; ?></span>
    </div>
</header>

<?php include "../php/menu-lateral.php"; ?>

<div class="background-shapes">
    <div class="circle big"></div>
    <div class="circle small"></div>
    <div class="circle tiny"></div>
</div>

<div class="container">
    <button>Ingrese el código del paciente</button>
    <button>Generar código de acceso</button>
    <button>Condición del paciente</button>
</div>

<?php if ($isLoggedIn): ?>
    <script src="../menu.js"></script>
<?php endif; ?>
</body>
</html>
