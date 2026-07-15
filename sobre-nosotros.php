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
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="Css/styless.css?v=5">
  <link rel="stylesheet" href="Css/session-menu.css">

  <link rel="stylesheet" href="Css/botones-globales.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="Css/dark-mode.css?v=1">
  <script src="dark-mode.js" defer></script>
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon_io%20%283%29/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon_io%20%283%29/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon_io%20%283%29/favicon-16x16.png">
    <link rel="shortcut icon" href="img/favicon_io%20%283%29/favicon.ico">
    <link rel="manifest" href="img/favicon_io%20%283%29/site.webmanifest">
</head>
<body class="about-page">

  <header class="navbar">

    <?php if ($isLoggedIn): ?>
      <button class="menu-icon" type="button" aria-label="Abrir menu" aria-controls="sideMenu" aria-expanded="false">
        &#9776;
      </button>
    <?php endif; ?>

    <div class="logo">

      <img src="img/Designer (16).png" alt="logo">

    </div>

    <nav>

      <a href="index.php">Inicio</a>
      <a href="sobre-nosotros.php" class="active">Sobre nosotros</a>
      <a href="actualizaciones2.php">Actualizaciones</a>

    </nav>

    <?php if ($isLoggedIn): ?>
      <a class="logout-btn" href="php/logout.php">Cerrar sesi&oacute;n</a>
    <?php endif; ?>

  </header>

  <?php if ($isLoggedIn): ?>
    <?php include "php/menu-lateral.php"; ?>
  <?php endif; ?>

  <div class="info-section">

    <div class="how-work">

      <h1>¿Cómo trabaja NearCare?</h1>

      <p>
        NearCare conecta pacientes, familiares y doctores
        mediante una plataforma digital que permite dar
        seguimiento al estado de salud, enviar reportes,
        monitorear pacientes y mantener una comunicación
        más cercana y humana.
      </p>

    </div>

    <img class="about-team-photo" src="img/_DSC7716.jpg" alt="Equipo de NearCare">

    <div class="cards-container">

      <div class="info-card">

        <div class="icon"> <img src="img/Designer (24).png" alt=""></div>

        <div class="card-content">

          <h2>Misión</h2>

          <p>
            Brindar una plataforma moderna y accesible
            que ayude a mejorar la comunicación médica,
            facilitando el cuidado y bienestar de las familias.
          </p>

        </div>

      </div>

      <div class="info-card">

        <div class="icon"><img src="img/Designer (25).png" alt=""></div>

        <div class="card-content">

          <h2>Visión</h2>

          <p>
            Convertirnos en una plataforma líder en salud digital,
            ofreciendo soluciones tecnológicas innovadoras que
            acerquen el cuidado médico a todas las personas.
          </p>

        </div>

      </div>

      <div class="info-card">

        <div class="icon"><img src="img/Designer (26).png" alt=""></div>

        <div class="card-content">

          <h2>Correo</h2>

          <p>
            Contáctanos para soporte, dudas o información.
          </p>

          <a href="https://mail.google.com/mail/?view=cm&fs=1&to=nearcare6@gmail.com">nearcare@gmail.com</a>

        </div>

      </div>

      <div class="info-card">

        <div class="icon"><img src="img/Desugner (27).png" alt=""></div>

        <div class="card-content">

          <h2>Instagram</h2>

          <p>
            Síguenos para conocer noticias,
            actualizaciones y contenido sobre NearCare.
          </p>

          <a href="https://www.instagram.com/nearcare_?igsh=MTQyOHA0MTc0anZ0dw==">@NearCare</a>

        </div>

      </div>

    </div>

  </div>

  <footer class="site-footer">
    <div class="footer-brand">
      <img src="img/Designer (16).png" alt="NearCare">
      <p>NearCare acerca a familias, pacientes y doctores con seguimiento claro y humano.</p>
    </div>

    <div class="footer-contact">
      <h3>Contacto</h3>
      <p>nearcare6@gmail.com</p>
      <p>Instagram: <a href="https://www.instagram.com/nearcare_?igsh=MTQyOHA0MTc0anZ0dw==">@nearcare</a></p>
    </div>

    <div class="footer-bottom">
      <p>&copy; <?php echo date('Y'); ?> NearCare. Todos los derechos reservados.</p>
    </div>
  </footer>

  <?php if ($isLoggedIn): ?>
    <script src="menu.js"></script>
  <?php endif; ?>
</body>
</html>
