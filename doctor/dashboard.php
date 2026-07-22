<?php
session_start();
require_once __DIR__ . '/../php/saludo.php';

if(!isset($_SESSION['id_doctor'])){
    header("Location: login-form.php");
    exit();
}

$nombre = $_SESSION['nombre'];
$saludo = nearcare_saludo($nombre);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Doctor</title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../Css/botones-globales.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../Css/dark-mode.css?v=<?php echo time(); ?>">
  <script src="../dark-mode.js?v=<?php echo time(); ?>" defer></script>
    <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon_io%20%283%29/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon_io%20%283%29/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon_io%20%283%29/favicon-16x16.png">
    <link rel="shortcut icon" href="../img/favicon_io%20%283%29/favicon.ico">
    <link rel="manifest" href="../img/favicon_io%20%283%29/site.webmanifest">
</head>
<body class="doctor-dashboard-page">

<?php include("menu_doctor.php"); ?>

<nav class="navbar">
    <div class="left-navbar">
      <button class="menu-icon" type="button" onclick="abrirMenu()" aria-label="Abrir menú" aria-controls="sideMenu" aria-expanded="false">☰</button>

        <a class="logo" href="../index.php" aria-label="Volver al inicio de NearCare">
            <img src="../img/Designer (16).png" alt="NearCare">
        </a>
    </div>

    <h1><?php echo htmlspecialchars($nombre); ?></h1>
</nav>

<div class="circle circle1"></div>
<div class="circle circle2"></div>
<div class="circle circle3"></div>
<div class="circle circle4"></div>
<div class="circle circle5"></div>

<main class="dashboard-main">
    <section class="welcome-card">
        <h2><?php echo $saludo; ?>, <?php echo htmlspecialchars($nombre); ?></h2>
    </section>

    <div class="menu-doctor">
        <a href="pacientes.php" class="btn-paciente">
            <span>Pacientes</span>
        </a>
        <a href="../Comentarios.php" class="btn-comentarios">
            <span>Comentarios</span>
        </a>
    </div>
</main>

</body>
</html>
