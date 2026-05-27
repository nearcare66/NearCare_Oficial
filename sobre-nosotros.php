<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>NearCare</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="styless.css">

</head>
<body>

  <header class="navbar">

    <button class="menu-icon" type="button" aria-label="Abrir menu" aria-controls="sideMenu" aria-expanded="false">
      &#9776;
    </button>

    <div class="logo">

      <img src="img/Designer (16).png" alt="logo">

    </div>

    <nav>

      <a href="index.php">Inicio</a>
      <a href="sobre-nosotros.php" class="active">Sobre nosotros</a>
      <a href="actualizaciones2.php">Actualizaciones</a>

    </nav>

  </header>

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
      <a href="#">Comentarios</a>
    </div>
  </aside>

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

      <div class="info-card">

        <div class="icon">🎯</div>

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

        <div class="icon">🚀</div>

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

        <div class="icon">📧</div>

        <div class="card-content">

          <h2>Outlook</h2>

          <p>
            Contáctanos para soporte, dudas o información.
          </p>

          <a href="#">nearcare@outlook.com</a>

        </div>

      </div>

      <div class="info-card">

        <div class="icon">📸</div>

        <div class="card-content">

          <h2>Instagram</h2>

          <p>
            Síguenos para conocer noticias,
            actualizaciones y contenido sobre NearCare.
          </p>

          <a href="#">@NearCare</a>

        </div>

      </div>

    </div>

  </div>

  <script src="menu.js"></script>
</body>
</html>
