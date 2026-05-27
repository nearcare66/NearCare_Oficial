<?php
// Configuración de rutas y textos dinámicos del proyecto PHP
$pageTitle = "NearCare - Sección de Médico";
$sectionTitle = "Sección de médico";
$logoPath = "images/Multimedia__7_-removebg-preview.png";
$doctorPath = "images/Copilot_20260526_215821.png";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <!-- Vinculación del archivo CSS externo -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <div class="interface-container">
        
        <header class="navbar">
            <div class="nav-left">
                <div class="menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="logo-container">
                    <img src="<?php echo $logoPath; ?>" alt="Logo NearCare">
                </div>
            </div>
            
            <h1 class="nav-title"><?php echo $sectionTitle; ?></h1>
            
            <div class="nav-spacer"></div>
        </header>

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
                <a href="comentarios.php" class="btn btn-comments">Comentarios públicos</a>
            </div>
        </main>
    </div>

</body>
</html>
