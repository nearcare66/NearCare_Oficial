<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

$isLoggedIn = isset($_SESSION['usuario_id']);

// Configuración de rutas y textos dinámicos del proyecto PHP
$pageTitle = "NearCare - Sección de Médico";
$sectionTitle = "Sección de médico";
$logoPath = "../img/Designer (16).png";
$doctorPath = "img/doctorrr.webp";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>

    <!-- Vinculación del archivo CSS externo -->
<<<<<<< HEAD:sección-médico.php
    <link rel="stylesheet" href="Css/styles.css">
    <link rel="stylesheet" href="Css/session-menu.css">
    <link rel="stylesheet" href="Css/botones-globales.css?v=1">
=======
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="../Css/session-menu.css">
  <link rel="stylesheet" href="../Css/botones-globales.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../Css/dark-mode.css?v=1">
  <script src="../dark-mode.js" defer></script>
    <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon_io%20%283%29/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon_io%20%283%29/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon_io%20%283%29/favicon-16x16.png">
    <link rel="shortcut icon" href="../img/favicon_io%20%283%29/favicon.ico">
    <link rel="manifest" href="../img/favicon_io%20%283%29/site.webmanifest">
>>>>>>> ed2c56b87a0d5c86c832b09d013d3e57699ec6b7:doctor/sección-médico.php
</head>

<body>

    <div class="interface-container">

        <header class="navbar">
            <div class="nav-left">

                <?php if ($isLoggedIn): ?>
                    <button class="menu-toggle menu-icon" type="button" aria-label="Abrir menú" aria-controls="sideMenu" aria-expanded="false">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                <?php endif; ?>

                <div class="logo-container">
                    <img src="<?php echo $logoPath; ?>" alt="Logo de NearCare">
                </div>

            </div>

            <h1 class="nav-title"><?php echo $sectionTitle; ?></h1>

            <div class="nav-spacer"></div>
        </header>

        <?php include "../php/menu-lateral.php"; ?>

        <main class="main-content">

            <!-- Círculos de fondo con relieve 3D -->
            <div class="background-shapes">
                <div class="sphere circle-large"></div>
                <div class="sphere circle-medium"></div>
                <div class="sphere circle-small"></div>
            </div>

            <!-- Ilustración del médico -->
            <div class="doctor-container">
                <img src="<?php echo $doctorPath; ?>" alt="Médico" class="doctor-img">
            </div>

            <!-- Grupo de botones agrandados y elevados -->
            <div class="button-group">
<<<<<<< HEAD:sección-médico.php
                <a href="pacientes.php" class="btn btn-patient">Ver pacientes</a>
                <a href="comentarios.php" class="btn btn-comments">Comentarios públicos</a>
=======
                <a href="pacientes.php" class="btn btn-patient">Ver Pacientes</a>
                <a href="Comentarios-admin.php" class="btn btn-comments">Comentarios públicos</a>
>>>>>>> ed2c56b87a0d5c86c832b09d013d3e57699ec6b7:doctor/sección-médico.php
            </div>

        </main>

    </div>

    <?php if ($isLoggedIn): ?>
        <script src="../menu.js"></script>
    <?php endif; ?>

</body>
</html>
