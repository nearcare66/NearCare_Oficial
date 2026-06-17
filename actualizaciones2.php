<?php
session_start();
$isLoggedIn = isset($_SESSION['usuario_id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>NearCare - Notificaciones</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="Css/styless.css">
  <link rel="stylesheet" href="Css/session-menu.css">
</head>
<body>

  <header class="navbar">
    <?php if ($isLoggedIn): ?>
      <button class="menu-icon" type="button" aria-label="Abrir menu" aria-controls="sideMenu" aria-expanded="false">
        &#9776;
      </button>
    <?php endif; ?>

    <a href="index.php"class="back-arrow">←</a>

    <div class="logo">
      <img src="img/Designer (16).png" alt="logo">
    </div>

    <div class="search-box">
      <input type="text" placeholder="Buscar paciente...">
    </div>

    <div class="notifications">
      🔔
      <span>3</span>
    </div>

  </header>

  <?php include "php/menu-lateral.php"; ?>

  <div class="circle circle1"></div>
  <div class="circle circle2"></div>
  <div class="circle circle3"></div>
  <div class="circle circle4"></div>
  <div class="circle circle5"></div>

  <div class="notifications-section">

    <h1>Notificaciones</h1>

    <div class="notification-card">

      <div class="icon">
        👤
      </div>

      <div class="notification-text">

        <h2>
          ESTADO DE ACTUALIZACIÓN DEL PACIENTE, CRUZ DAYANA
        </h2>

        <p>
          Lorem ipsum dolor sit amet consectetur adipiscing elit
          et massa mi. Aliquam in hendrerit urna.
        </p>

      </div>

    </div>

    <div class="notification-card">

      <div class="icon">
        👤
      </div>

      <div class="notification-text">

        <h2>
          ESTADO DE ACTUALIZACIÓN DEL PACIENTE, CRUZ DAYANA
        </h2>

        <p>
          Lorem ipsum dolor sit amet consectetur adipiscing elit
          et massa mi. Aliquam in hendrerit urna.
        </p>

      </div>

    </div>

    <div class="notification-card">

      <div class="icon">
        👤
      </div>

      <div class="notification-text">

        <h2>
          ESTADO DE ACTUALIZACIÓN DEL PACIENTE, CRUZ DAYANA
        </h2>

        <p>
          Lorem ipsum dolor sit amet consectetur adipiscing elit
          et massa mi. Aliquam in hendrerit urna.
        </p>

      </div>

    </div>

    <div class="notification-card">

      <div class="icon">
        👤
      </div>

      <div class="notification-text">

        <h2>
          ESTADO DE ACTUALIZACIÓN DEL PACIENTE, CRUZ DAYANA
        </h2>

        <p>
          Lorem ipsum dolor sit amet consectetur adipiscing elit
          et massa mi. Aliquam in hendrerit urna.
        </p>

      </div>

    </div>

  </div>

  <?php if ($isLoggedIn): ?>
    <script src="menu.js"></script>
  <?php endif; ?>
</body>
</html>
