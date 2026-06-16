<?php
session_start();
$isLoggedIn = isset($_SESSION['usuario_id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>NearCare</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="Css/styless.css">

</head>
<body>

  <header class="navbar">


    <div class="left-navbar">
      <?php if ($isLoggedIn): ?>
        <button class="menu-icon" type="button" aria-label="Abrir menu" aria-controls="sideMenu" aria-expanded="false">
          &#9776;
        </button>
      <?php endif; ?>

      <a href="index.php" class="back-arrow">&larr;</a>

      <div class="logo">
        <img src="img/Designer (16).png" alt="">
      </div>
    </div>

    <div class="profile">

      <img src="https://cdn-icons-png.flaticon.com/512/4140/4140048.png">

      <div class="welcome-box">

        <span>Bienvenido</span>

        <div class="toggle"></div>

      </div>

    </div>

  </header>

  <?php if ($isLoggedIn): ?>
    <div class="menu-overlay" data-close-menu></div>

    <aside class="side-menu" id="sideMenu" aria-hidden="true">
      <div class="side-menu-strip"></div>
      <div class="side-menu-content">
        <img class="side-menu-logo" src="img/Designer (16).png" alt="NearCare">
        <a href="index.php">Inicio</a>
        <a href="doctor-familiar.php" class="active">Familiar o doctor</a>
        <a href="#" class="active">Familiar</a>
        <a href="#">Doctor</a>
        <hr>
        <a href="sobre-nosotros.php">Sobre nosotros</a>
        <a href="actualizaciones2.php">Actualizaciones</a>
        <a href="Comentarios.php">Comentarios</a>
      </div>
    </aside>
  <?php endif; ?>


  <div class="selection-section">

    <div class="circle circle1"></div>
    <div class="circle circle2"></div>
    <div class="circle circle3"></div>
    <div class="circle circle4"></div>

   <div class="selection-buttons">

  <a href="loging.html">
    <button>
      Iniciar Sesion
    </button>
  </a>

   <a href="register.html">
    <button>
      Registrarse
    </button>

</div>

  </div>
  <?php if ($isLoggedIn): ?>
    <script src="menu.js"></script>
  <?php endif; ?>
</body>
</html>
