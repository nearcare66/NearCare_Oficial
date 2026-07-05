<?php
session_start();
require_once __DIR__ . '/php/site-cards-data.php';

$isLoggedIn =
    isset($_SESSION['usuario_id']) ||
    isset($_SESSION['id_doctor']) ||
    isset($_SESSION['id_familiar']);

$hasPaciente = isset($_SESSION['paciente_nc']) && trim((string)$_SESSION['paciente_nc']) !== '';
$problemCards = getSiteCards('index', 'problems');
$whyCards = getSiteCards('index', 'why');
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>NearCare</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="Css/styless.css?v=15">
  <link rel="stylesheet" href="Css/botones-globales.css?v=2">
</head>
<body>

  <header class="navbar">

    <?php if ($isLoggedIn): ?>
      <button class="menu-icon" type="button" aria-label="Abrir menu" aria-controls="sideMenu" aria-expanded="false">
        &#9776;
      </button>
    <?php endif; ?>

    <div class="logo">
      <img src="img/Designer (16).png" alt="">
    </div>

    <nav>
      <a href="index.php" class="active">Inicio</a>
      <a href="sobre-nosotros.php">Sobre nosotros</a>
      <a href="actualizaciones2.php">Actualizaciones</a>
    </nav>

    <?php if ($isLoggedIn): ?>
      <a class="logout-btn" href="php/logout.php">Cerrar sesi&oacute;n</a>
    <?php endif; ?>

  </header>

  <?php if ($isLoggedIn): ?>
    <div class="menu-overlay" data-close-menu></div>

    <aside class="side-menu" id="sideMenu" aria-hidden="true">
      <div class="side-menu-strip"></div>
      <div class="side-menu-content">
        <img class="side-menu-logo" src="img/Designer (16).png" alt="NearCare">
        <a href="index.php" class="active">Inicio</a>
        <a href="actualizaciones2.php">Actualizaciones</a>
        <hr>
        <a href="Comentarios.php">Comentarios</a>
        <a href="perfildoctor.html">Doctor encargado</a>
      </div>
    </aside>
  <?php endif; ?>

  <div class="hero">

    <div class="hero-text">

      <h1>
        Bienvenido a <br>
        <span>NearCare!</span>
      </h1>

      <p>
        Nosotros acercamos la distancia
        con tecnología e impacto humano
        para saber sobre el estado de tu familia.
      </p>

  <?php if (isset($_SESSION['usuario_id'])): ?>
    <a href="<?php echo $hasPaciente ? 'paciente-familiar.php' : 'registro2.php'; ?>" class="btn-green">
      Ver paciente
    </a>
  <?php elseif (isset($_SESSION['id_doctor'])): ?>
    <a href="doctor/dashboard.php" class="btn-green">
      Panel doctor
    </a>
  <?php else: ?>
  <a href="doctor-familiar.php" class="btn-green">
    ¿Eres un familiar o un doctor?
  </a>
  <?php endif; ?>

    </div>

    <div class="hero-image">

      <img src="https://images.unsplash.com/photo-1584515933487-779824d29309?q=80&w=1200&auto=format&fit=crop" alt="doctor">

    </div>

  </div>

  <div class="video-section">

    <div class="video-card">

      <div class="video-image">
        <div class="play-btn">&#9654;</div>
      </div>

      <div class="video-info">
        <h3>Mira como funciona NearCare</h3>
        <p>Video de presentación</p>
        <span>1:35 min</span>
      </div>

    </div>

  </div>

  <div class="problems">

    <h2>¿En que problemas trabaja NearCare?</h2>

    <div class="cards">

      <?php foreach ($problemCards as $card): ?>
        <div class="card">
          <img src="<?php echo siteCardE($card['image_src']); ?>" alt="<?php echo siteCardE($card['image_alt']); ?>">
          <h3><?php echo siteCardE($card['title']); ?></h3>
          <p><?php echo siteCardE($card['description']); ?></p>
        </div>
      <?php endforeach; ?>

      <?php if (empty($problemCards)): ?>

      <div class="card">

        <img src="img/Designer (19).png?v=2" alt="Icono de distancia">

        <h3>Distancia</h3>

        <p>
          La distancia fisica es un obstaculo
          para el cuidado y la atención constante
          de tus familiares.
        </p>

      </div>

      <div class="card">

        <img src="img/Designer (20).png?v=2" alt="Icono de falta de tiempo">

        <h3>Falta de tiempo</h3>

        <p>
          La rutina diaria puede dificultar
          encontrar tiempo para monitorear
          la salud.
        </p>

      </div>

      <div class="card">

        <img src="img/Designer (21).png?v=2" alt="Icono de falta de informaci&oacute;n">

        <h3>Falta de información</h3>

        <p>
          La falta de información clara puede
          generar preocupación e incertidumbre.
        </p>

      </div>

      <?php endif; ?>

    </div>

  </div>

  <div class="about">

    <div class="about-text">

      <h2>¿Qué es NearCare?</h2>

      <p>
        NearCare es una plataforma digital
        de salud que conecta pacientes y profesionales,
        facilitando citas, seguimiento y comunicación.
      </p>

    </div>

    <div class="about-image">
      <img src="https://images.unsplash.com/photo-1624727828489-a1e03b79bba8?q=80&w=1200&auto=format&fit=crop">
    </div>

  </div>

  <div class="why">

    <h2>¿Por qué fue creado NearCare?</h2>

    <div class="why-cards">

      <?php foreach ($whyCards as $card): ?>
        <div class="why-card">
          <img src="<?php echo siteCardE($card['image_src']); ?>" alt="<?php echo siteCardE($card['image_alt']); ?>">
          <h3><?php echo siteCardE($card['title']); ?></h3>
          <p><?php echo siteCardE($card['description']); ?></p>
        </div>
      <?php endforeach; ?>

      <?php if (empty($whyCards)): ?>

      <div class="why-card">

        <img src="img/Designer (22).png?v=2" alt="Icono del problema">

        <h3>El problema</h3>

        <p>
          Existe dificultad para acceder
          a atención medica rápida y cercana.
        </p>

      </div>

      <div class="why-card">

        <img src="img/Designer (23).png?v=2" alt="Icono de la soluci&oacute;n">

        <h3>La solución</h3>

        <p>
          NearCare conecta pacientes y profesionales
          para mejorar la comunicación y seguimiento.
        </p>

      </div>

      <?php endif; ?>

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
