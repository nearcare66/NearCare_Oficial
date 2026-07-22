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
  <link rel="stylesheet" href="Css/botones-globales.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="Css/dark-mode.css?v=<?php echo time(); ?>">
  <script src="dark-mode.js?v=<?php echo time(); ?>" defer></script>
</head>
<body>

<header class="navbar">
    
<div class="circle-big"></div>
<div class="circle-small"></div>
<div class="circle-right"></div>
<div class="circle-corner"></div>

    <div class="left">
        <?php if ($isLoggedIn): ?>
            <button class="menu-icon" type="button" aria-label="Abrir menú" aria-controls="sideMenu" aria-expanded="false">
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
    <button>Ingrese el código del paciente</button>
    <button>Generar código de acceso</button>
    <button>Condición del paciente</button>
</div>

<?php if ($isLoggedIn): ?>
    <script src="menu.js"></script>
<?php endif; ?>
</body>
</html>
$target = 'familiar/Familiares-opciones.php';
if (!empty($_SERVER['QUERY_STRING'])) {
    $target .= '?' . $_SERVER['QUERY_STRING'];
}
header('Location: ' . $target);
exit;
?>
