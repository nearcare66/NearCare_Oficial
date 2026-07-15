<?php
session_start();
require_once __DIR__ . '/php/site-cards-data.php';
$isLoggedIn = isset($_SESSION['usuario_id']);
$aboutCards = getSiteCards('about', 'info');
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>NearCare</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="Css/styless.css?v=20">
  <link rel="stylesheet" href="Css/botones-globales.css?v=2">
</head>
<body class="about-page">

  <header class="navbar">

    <?php if ($isLoggedIn): ?>
      <button class="menu-icon" type="button" aria-label="Abrir menú" aria-controls="sideMenu" aria-expanded="false">
        &#9776;
      </button>
    <?php endif; ?>

    <div class="logo">
      <img src="img/Designer (16).png" alt="Logo de NearCare">
    </div>

    <nav>
      <a href="index.php">Inicio</a>
      <a href="sobre-nosotros.php" class="active">Sobre nosotros</a>
      <a href="actualizaciones2.php">Actualizaciones</a>
    </nav>

    <?php if ($isLoggedIn): ?>
      <a class="logout-btn" href="php/logout.php">Cerrar sesión</a>
    <?php endif; ?>

  </header>

  <?php if ($isLoggedIn): ?>
    <div class="menu-overlay" data-close-menu></div>

    <aside class="side-menu" id="sideMenu" aria-hidden="true">
      <div class="side-menu-strip"></div>
      <div class="side-menu-content">
        <img class="side-menu-logo" src="img/Designer (16).png" alt="NearCare">
        <a href="index.php">Inicio</a>
        <a href="doctor-familiar.php">Familiar o doctor</a>
        <a href="#">Familiar</a>
        <a href="#">Doctor</a>
        <hr>
        <a href="sobre-nosotros.php" class="active">Sobre nosotros</a>
        <a href="actualizaciones2.php">Actualizaciones</a>
        <a href="Comentarios.php">Comentarios</a>
      </div>
    </aside>
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

    <div class="cards-container">

      <?php foreach ($aboutCards as $card): ?>
        <div class="info-card">
          <div class="icon">
            <img src="<?php echo siteCardE($card['image_src']); ?>" alt="<?php echo siteCardE($card['image_alt']); ?>">
          </div>

          <div class="card-content">
            <h2><?php echo siteCardE($card['title']); ?></h2>
            <p><?php echo siteCardE($card['description']); ?></p>

            <?php if (!empty($card['link_url']) && !empty($card['link_text'])): ?>
              <a href="<?php echo siteCardE($card['link_url']); ?>"><?php echo siteCardE($card['link_text']); ?></a>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>

      <?php if (empty($aboutCards)): ?>

      <div class="info-card">

        <div class="icon">
          <img src="img/Designer (24).png" alt="Misión">
        </div>

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

        <div class="icon">
          <img src="img/Designer (25).png" alt="Visión">
        </div>

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

        <div class="icon">
          <img src="img/Designer (26).png" alt="Correo">
        </div>

        <div class="card-content">

          <h2>Correo</h2>

          <p>
            Contáctanos para soporte, dudas o información.
          </p>

          <a href="https://mail.google.com/mail/?view=cm&fs=1&to=nearcare6@gmail.com">
            nearcare6@gmail.com
          </a>

        </div>

      </div>

      <div class="info-card">

        <div class="icon">
          <img src="img/Designer (27).png" alt="Instagram">
        </div>

        <div class="card-content">

          <h2>Instagram</h2>

          <p>
            Síguenos para conocer noticias,
            actualizaciones y contenido sobre NearCare.
          </p>

          <a href="https://www.instagram.com/nearcare_?igsh=MTQyOHA0MTc0anZ0dw==">
            @NearCare
          </a>

        </div>

      </div>

      <?php endif; ?>

    </div>

  </div>

  <footer class="site-footer">
    <div class="footer-brand">
      <img src="img/Designer (16).png" alt="NearCare">
      <p>
        NearCare acerca a familias, pacientes y doctores con
        seguimiento claro y humano.
      </p>
    </div>

    <div class="footer-contact">
      <h3>Contacto</h3>
      <p>nearcare6@gmail.com</p>
      <p>
        Instagram:
        <a href="https://www.instagram.com/nearcare_?igsh=MTQyOHA0MTc0anZ0dw==">
          @nearcare
        </a>
      </p>
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
