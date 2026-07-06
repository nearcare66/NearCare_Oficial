<?php
session_start();
require_once __DIR__ . '/../php/saludo.php';

if (isset($_SESSION['id_doctor'])) {
  header("Location: ../doctor/dashboard.php");
  exit();
}

if (isset($_SESSION['usuario_id'])) {
  header("Location: ../index.php");
  exit();
}

$isLoggedIn = false;
$saludo = nearcare_saludo($_SESSION['usuario'] ?? $_SESSION['registro_nombre'] ?? $_SESSION['nombre'] ?? '');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NearCare</title>

  <link rel="stylesheet" href="../Css/style.css?v=9">
  <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../Css/botones-globales.css?v=<?php echo time(); ?>">
</head>
<body class="doctor-family-page">

 
   <header class="navbar">


    <div class="left-navbar">
      <?php if ($isLoggedIn): ?>
        <button class="menu-icon" type="button" aria-label="Abrir menu" aria-controls="sideMenu" aria-expanded="false">
          &#9776;
        </button>
      <?php endif; ?>

      <a href="../index.php" class="back-arrow">&#8249;</a>

      <div class="logo">
        <img src="../img/Designer (16).png" alt="">
      </div>
    </div>

    <div class="profile">

      <div class="welcome-box">

        <span><?php echo $saludo; ?></span>

        <div class="toggle"></div>

      </div>

    </div>

  </header>

  <?php if ($isLoggedIn): ?>
    <?php include "../php/menu-lateral.php"; ?>
  <?php endif; ?>

  <!-- CONTENIDO -->
  <main class="main-container">

    <!-- CIRCULOS -->
    <div class="circle-left"></div>
    <div class="circle-right"></div>

    <div class="choice-heading">
      <span>Acceso NearCare</span>
      <h1>Elige cómo quieres ingresar</h1>
      <p>Selecciona tu perfil para continuar con tu cuenta.</p>
    </div>

    <!-- CARD IZQUIERDA -->
    <section class="card">
      <h2>Doctor</h2>
      <img src="../doctor/img/doctor.png" alt="">
      <?php if (!$isLoggedIn): ?>
      <a href="../doctor/login-form.php">
         <button>Iniciar Sesión</button>
      </a>
     <a href="../doctor/register-form.php">
      <button>Registrarse</button>
     </a>
      <?php else: ?>
        <p class="session-note">Cierra sesi&oacute;n como familiar para acceder como doctor.</p>
      <?php endif; ?>
    </section>

    <!-- LINEA -->
    <div class="divider"></div>

    
    <section class="card">
     <h2>Familiar</h2>
     <img src="../img/image.png" alt="">
      <a href="loging.php">
         <button>Iniciar Sesión</button>
      </a>
     <a href="register.php">
      <button>Registrarse</button>
     </a>
    </section>
  </main>
</body>
<?php if ($isLoggedIn): ?>
  <script src="../menu.js"></script>
<?php endif; ?>
</html>
