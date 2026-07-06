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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NearCare Acceso</title>
  <link rel="stylesheet" href="../Css/loging.css">
  <link rel="stylesheet" href="../Css/session-menu.css">
  <link rel="stylesheet" href="../Css/botones-globales.css?v=<?php echo time(); ?>">
</head>
<body class="nearcare-loading">
  <main class="page">
    <header class="navbar">
      <div class="nav-left">
        <?php if ($isLoggedIn): ?>
          <button class="menu-icon" type="button" aria-label="Abrir menu" aria-controls="sideMenu" aria-expanded="false">
            &#9776;
          </button>
        <?php endif; ?>
    <a href="index.php" class="back-arrow">&#8249;</a>
        <img class="brand" src="../img/Designer (16).png" alt="NearCare">
      </div>

      <div class="family-pill">Familiar</div>

      <div class="profile">
        <div class="welcome-box">
          <span><?php echo $saludo; ?></span>
          <div class="toggle" aria-hidden="true"></div>
        </div>
      </div>
    </header>

    <?php include "../php/menu-lateral.php"; ?>

    <div class="circle circle-dark circle-1"></div>
    <div class="circle circle-light circle-2"></div>
    <div class="circle circle-light circle-3"></div>
    <div class="circle circle-light circle-4"></div>
    <div class="circle circle-dark circle-5"></div>
    <div class="circle circle-light circle-6"></div>
    <div class="circle circle-dark circle-7"></div>
    <div class="circle circle-8"></div>
    <div class="circle circle-light circle-9"></div>

    <section class="login-card">
      <h1>Iniciar Sesion</h1>

      <form class="login-form" action="../php/login.php" method="POST">
        <input type="text" name="nombre" placeholder="Nombre..." required>
        <input type="email" name="correo" placeholder="Correo electronico" required>
        <input type="password" name="codigo" placeholder="Codigo..." required>

        <a class="register-link" href="register.php">¿No tienes cuenta? <span>Registrate</span></a>

        <button class="action-submit" type="submit">Iniciar sesion</button>
      </form>
    </section>
  </main>
  <?php if ($isLoggedIn): ?>
    <script src="../menu.js"></script>
  <?php endif; ?>
</body>
</html>
