<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>NearCare</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="Css/styless.css">
</head>
<body>

  <header class="navbar">

    <button class="menu-icon" type="button" aria-label="Abrir menu" aria-controls="sideMenu" aria-expanded="false">
      &#9776;
    </button>

    <div class="logo">
      <img src="img/Designer (16).png" alt="">
    </div>

    <nav>
      <a href="index.php" class="active">Inicio</a>
      <a href="sobre-nosotros.php">Sobre nosotros</a>
      <a href="actualizaciones2.php">Actualizaciones</a>
    </nav>

  </header>

  <div class="menu-overlay" data-close-menu></div>

  <aside class="side-menu" id="sideMenu" aria-hidden="true">
    <div class="side-menu-strip"></div>
    <div class="side-menu-content">
      <img class="side-menu-logo" src="img/Designer (16).png" alt="NearCare">
      <a href="index.php" class="active">Inicio</a>
      <a href="doctor-familiar.html">Familiar o doctor</a>
      <a href="#">Familiar</a>
      <a href="#">Doctor</a>
      <hr>
      <a href="sobre-nosotros.php">Sobre nosotros</a>
      <a href="actualizaciones2.php">Actualizaciones</a>
      <a href="#">Comentarios</a>
    </div>
  </aside>

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

      <a href="doctor-familiar.html">
        <button>¿Eres un familiar o un doctor?</button>
      </a>

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

      <div class="card">

        <img src="img/Designer (19).png">

        <h3>Distancia</h3>

        <p>
          La distancia fisica es un obstaculo
          para el cuidado y la atención constante
          de tus familiares.
        </p>

      </div>

      <div class="card">

        <img src="img/Designer (20).png">

        <h3>Falta de tiempo</h3>

        <p>
          La rutina diaria puede dificultar
          encontrar tiempo para monitorear
          la salud.
        </p>

      </div>

      <div class="card">

        <img src="img/Designer (21).png">

        <h3>Falta de información</h3>

        <p>
          La falta de información clara puede
          generar preocupación e incertidumbre.
        </p>

      </div>

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

      <div class="why-card">

        <img src="img/Designer (22).png">

        <h3>El problema</h3>

        <p>
          Existe dificultad para acceder
          a atención medica rápida y cercana.
        </p>

      </div>

      <div class="why-card">

        <img src="img/Designer (23).png">

        <h3>La solución</h3>

        <p>
          NearCare conecta pacientes y profesionales
          para mejorar la comunicación y seguimiento.
        </p>

      </div>

    </div>

  </div>

  <script src="menu.js"></script>
</body>
</html>
