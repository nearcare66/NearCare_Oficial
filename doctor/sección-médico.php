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
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="../Css/session-menu.css">
  <link rel="stylesheet" href="../Css/botones-globales.css?v=<?php echo time(); ?>">
</head>
<body>

    <div class="interface-container">
        
        <header class="navbar">
            <div class="nav-left">
                <?php if ($isLoggedIn): ?>
                    <button class="menu-toggle menu-icon" type="button" aria-label="Abrir menu" aria-controls="sideMenu" aria-expanded="false">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                <?php endif; ?>
                <div class="logo-container">
                    <img src="<?php echo $logoPath; ?>" alt="Logo NearCare">
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
                <img src="<?php echo $doctorPath; ?>" alt="Doctor" class="doctor-img">
            </div>

            <!-- Grupo de botones agrandados y elevados -->
            <div class="button-group">
                <a href="pacientes.php" class="btn btn-patient">Ver Pacientes</a>
                <a href="Comentarios-admin.php" class="btn btn-comments">Comentarios públicos</a>
            </div>
        </main>
    </div>

    <?php if ($isLoggedIn): ?>
        <script src="../menu.js"></script>
    <?php endif; ?>
</body>
</html>
