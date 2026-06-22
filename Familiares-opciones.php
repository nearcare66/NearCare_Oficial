<?php
session_start();
$isLoggedIn = isset($_SESSION['usuario_id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>NearCare</title>
    <link rel="stylesheet" href="Css/styles4.css">
    <link rel="stylesheet" href="Css/session-menu.css">
  <link rel="stylesheet" href="Css/botones-globales.css?v=1">
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
        <span class="back">âŸµ</span>
        <img src="img/Designer (16).png" class="logo" alt="NearCare">
    </div>

    <div class="right">
        <div class="avatar"></div>
        <span class="bienvenido">Bienvenido</span>
    </div>
</header>

<?php include "php/menu-lateral.php"; ?>

<div class="background-shapes">
    <div class="circle big"></div>
    <div class="circle small"></div>
    <div class="circle tiny"></div>
</div>

<div class="container">
    <button>Ingrese el cÃ³digo del paciente</button>
    <button>Generar cÃ³digo de acceso</button>
    <button>CondiciÃ³n del paciente</button>
</div>

<?php if ($isLoggedIn): ?>
    <script src="menu.js"></script>
<?php endif; ?>
</body>
</html>
