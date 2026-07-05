<?php
session_start();
$isLoggedIn = isset($_SESSION['usuario_id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NearCare Registro</title>
  <link rel="stylesheet" href="Css/session-menu.css">

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      min-height: 100vh;
      background: linear-gradient(180deg, #a6d9f4 0%, #dff4ff 100%);
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: Arial, Helvetica, sans-serif;
      color: #123c69;
    }

    .page {
      width: 100vw;
      min-height: 100vh;
      background: linear-gradient(180deg, #a6d9f4 0%, #dff4ff 100%);
      position: relative;
      overflow: hidden;
    }

    .navbar {
      height: 70px;
      background: #65b5d4;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 14px;
      position: relative;
      z-index: 5;
    }

    .nav-left,
    .profile {
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .back-link {
      width: 47px;
      height: 47px;
      border: 3px solid #071e31;
      border-radius: 50%;
      color: #071e31;
      text-decoration: none;
      display: grid;
      place-items: center;
      font-size: 36px;
      line-height: 1;
      font-weight: bold;
    }

    .brand {
      width: 112px;
      height: auto;
      display: block;
    }

    .family-pill {
      min-width: 168px;
      height: 34px;
      border-radius: 999px;
      background: #d6defc;
      display: grid;
      place-items: center;
      color: #111;
      font-family: Georgia, "Times New Roman", serif;
      font-size: 18px;
      font-weight: 700;
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
    }

    .user-icon {
      width: 34px;
      height: 34px;
      position: relative;
    }

    .user-icon::before {
      content: "";
      width: 20px;
      height: 20px;
      border-radius: 50%;
      background: linear-gradient(180deg, #96a1ff, #7045ed);
      position: absolute;
      top: 0;
      left: 7px;
    }

    .user-icon::after {
      content: "";
      width: 34px;
      height: 17px;
      background: linear-gradient(180deg, #7045ed, #5b44d8);
      clip-path: polygon(50% 0, 100% 100%, 0 100%);
      position: absolute;
      bottom: 0;
      left: 0;
    }

    .welcome-box {
      height: 30px;
      min-width: 111px;
      border-radius: 999px;
      background: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      color: #111;
      font-family: Georgia, "Times New Roman", serif;
      font-size: 13px;
      font-weight: 700;
      padding: 0 7px;
    }

    .toggle {
      width: 22px;
      height: 18px;
      border-radius: 999px;
      background: #d9d9d9;
      position: relative;
    }

    .toggle::after {
      content: "";
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: #fff;
      position: absolute;
      top: 4px;
      left: 4px;
    }

    .register-card {
      width: min(330px, 86vw);
      min-height: 420px;
      background: linear-gradient(180deg, rgba(122, 191, 223, 0.72), rgba(208, 223, 241, 0.9));
      border-radius: 30px;
      position: relative;
      z-index: 4;
      margin: 49px auto 0;
      padding: 48px 32px 28px;
      display: flex;
      flex-direction: column;
      align-items: center;
      box-shadow: 0 4px 18px rgba(56, 92, 120, 0.12);
    }

    .register-card h1 {
      color: #127bc0;
      font-size: 28px;
      margin-bottom: 42px;
      font-weight: 800;
    }

    .register-form {
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 24px;
    }

    .register-form input {
      width: 100%;
      max-width: 260px;
      height: 42px;
      border: 0;
      border-radius: 999px;
      background: #eef9ff;
      color: #176fa8;
      text-align: center;
      font-size: 15px;
      outline: none;
      padding: 0 18px;
    }

    .register-form input::placeholder {
      color: #94c8e8;
    }

    .action-submit {
      width: 100%;
      max-width: 260px;
      height: 42px;
      border: 0;
      border-radius: 999px;
      background: #127bc0;
      color: #fff;
      cursor: pointer;
      font-size: 15px;
      font-weight: 700;
      transition: transform 0.2s ease, background 0.2s ease;
    }

    .action-submit:hover {
      background: #0d66a0;
      transform: translateY(-2px);
    }

    .circle {
      position: absolute;
      border-radius: 50%;
      z-index: 1;
    }

    .circle-dark {
      background: linear-gradient(150deg, #4969b4 0%, #273f7b 72%);
    }

    .circle-light {
      background: linear-gradient(150deg, #9fc6ee 0%, #3d4b69 80%);
    }

    .circle-1 {
      width: 96px;
      height: 96px;
      top: 86px;
      left: -70px;
    }

    .circle-2 {
      width: 92px;
      height: 92px;
      top: 130px;
      left: -49px;
    }

    .circle-3 {
      width: 48px;
      height: 48px;
      top: 86px;
      left: 127px;
    }

    .circle-4 {
      width: 72px;
      height: 72px;
      right: 82px;
      top: 146px;
    }

    .circle-5 {
      width: 92px;
      height: 92px;
      right: 31px;
      top: 192px;
    }

    .circle-6 {
      width: 68px;
      height: 68px;
      left: 185px;
      bottom: 65px;
    }

    .circle-7 {
      width: 100px;
      height: 100px;
      left: -50px;
      bottom: -35px;
    }

    .circle-8 {
      width: 210px;
      height: 210px;
      right: -72px;
      bottom: -100px;
      background: linear-gradient(140deg, #4b75d6, #2e468c);
    }

    .circle-9 {
      width: 126px;
      height: 126px;
      right: -62px;
      bottom: 30px;
    }

    @media (max-width: 780px) {
      body {
        align-items: flex-start;
      }

      .page {
        width: 100vw;
        min-height: 100dvh;
        border: 0;
        overflow-y: auto;
      }

      .navbar {
        height: auto;
        min-height: 70px;
        flex-wrap: wrap;
        gap: 8px;
        padding: 10px 14px;
      }

      .nav-left,
      .profile {
        flex-wrap: nowrap;
        gap: 8px;
      }

      .family-pill {
        position: static;
        transform: none;
        order: 3;
        min-width: 100%;
        height: 30px;
        font-size: 14px;
      }

      .brand {
        width: 112px;
      }

      .profile {
        margin-left: auto;
      }

      .welcome-box {
        min-width: auto;
        font-size: 12px;
      }

      .register-card {
        margin: 28px auto 32px;
        min-height: auto;
      }
    }
  </style>
  <link rel="stylesheet" href="Css/botones-globales.css?v=2">
</head>
<body>
  <main class="page">
    <header class="navbar">
      <div class="nav-left">
        <?php if ($isLoggedIn): ?>
          <button class="menu-icon" type="button" aria-label="Abrir menu" aria-controls="sideMenu" aria-expanded="false">
            &#9776;
          </button>
        <?php endif; ?>
       <a href="doctor-familiar.php" class="back-arrow">&#8249;</a>

        <img class="brand" src="img/Designer (16).png" alt="NearCare">
      </div>

      <div class="family-pill">Familiar</div>

      <div class="profile">
        <div class="welcome-box">
          <span>Bienvenido</span>
          <div class="toggle" aria-hidden="true"></div>
        </div>
      </div>
    </header>

    <?php include "php/menu-lateral.php"; ?>

    <div class="circle circle-dark circle-1"></div>
    <div class="circle circle-light circle-2"></div>
    <div class="circle circle-light circle-3"></div>
    <div class="circle circle-light circle-4"></div>
    <div class="circle circle-dark circle-5"></div>
    <div class="circle circle-light circle-6"></div>
    <div class="circle circle-dark circle-7"></div>
    <div class="circle circle-8"></div>
    <div class="circle circle-light circle-9"></div>

    <section class="register-card">
      <h1>Registrate</h1>

      <form class="register-form" action="php/guardar.php" method="POST">
        <input type="text" name="nombre" placeholder="Nombre..." required>
        <input type="email" name="correo" placeholder="Correo electronico" required>
        <input type="password" name="codigo" placeholder="Codigo..." required>

        <button class="action-submit" type="submit" name="registrar">Registrarse</button>
      </form>
    </section>
  </main>
  <?php if ($isLoggedIn): ?>
    <script src="menu.js"></script>
  <?php endif; ?>
</body>
</html>
