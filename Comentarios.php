<?php
session_start();
$isLoggedIn = isset($_SESSION['usuario_id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>NearCare</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="Css/styles5.css">
  <link rel="stylesheet" href="Css/session-menu.css">
</head>
<body>
    <main>
    <header class="navbar">
    <?php if ($isLoggedIn): ?>
      <button class="menu-icon" type="button" aria-label="Abrir menu" aria-controls="sideMenu" aria-expanded="false">
        &#9776;
      </button>
    <?php endif; ?>

    <a href="index.php" class="back-btn">←</a>

    <div class="logo">
        <img src="img/Designer (16).png" alt="">
    </div>

    <div class="profile">
        <img src="https://cdn-icons-png.flaticon.com/512/4140/4140048.png">
        <span class="welcome">Bienvenido</span>
    </div>

    </header>
    <?php include "php/menu-lateral.php"; ?>
    </main>

    <div class="bg-bubbles">
    <div class="b1"></div>
    <div class="b2"></div>
    <div class="b3"></div>
    <div class="b4"></div>

    <!-- nuevas -->
    <div class="b5"></div>
    <div class="b6"></div>
    <div class="b7"></div>
    <div class="b8"></div>
    <div class="b9"></div>
    </div>
    <div class="container">


        <div class="info-bar">
            NearCare agradecerá tu opinión sobre nuestros trabajo y que podemos implementar
        </div>

        
        <div class="comment-box">
            <textarea placeholder="Escribe tu comentario..."></textarea>
        </div>


        <button class="btn-enviar">Enviar</button>

    </div>

    <?php if ($isLoggedIn): ?>
      <script src="menu.js"></script>
    <?php endif; ?>
</body>
</html>
