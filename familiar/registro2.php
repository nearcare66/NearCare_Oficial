<?php require_once __DIR__ . '/../php/registro2-data.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NearCare Registro Familiar</title>
  <link rel="stylesheet" href="../Css/registro2.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../Css/botones-globales.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../Css/dark-mode.css?v=1">
  <script src="../dark-mode.js" defer></script>
    <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon_io%20%283%29/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon_io%20%283%29/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon_io%20%283%29/favicon-16x16.png">
    <link rel="shortcut icon" href="../img/favicon_io%20%283%29/favicon.ico">
    <link rel="manifest" href="../img/favicon_io%20%283%29/site.webmanifest">
</head>
<body>
  <main class="page">
    <header class="navbar">
      <div class="nav-left">
        <a href="index.php" class="back-arrow">&#8249;</a>
        <img class="brand" src="../img/Designer (16).png" alt="NearCare">
      </div>

      <div class="family-pill">Familiar</div>

      <div class="profile">
        <div class="user-icon" aria-hidden="true"></div>
        <div class="welcome-box">
          <span><?php echo $saludo; ?></span>
          <div class="toggle" aria-hidden="true"></div>
        </div>
      </div>
    </header>

    <div class="circle circle-dark circle-1"></div>
    <div class="circle circle-light circle-2"></div>
    <div class="circle circle-light circle-3"></div>
    <div class="circle circle-light circle-4"></div>
    <div class="circle circle-dark circle-5"></div>
    <div class="circle circle-light circle-6"></div>
    <div class="circle circle-dark circle-7"></div>
    <div class="circle circle-8"></div>
    <div class="circle circle-light circle-9"></div>

    <section class="welcome-card">
      <h1><?php echo $saludo; ?></h1>
      <div class="welcome-name"><?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?></div>

      <form class="welcome-form" action="paciente-familiar.php" method="GET">
        <input type="number" name="id_doctor" placeholder="ID del doctor..." min="1">
        <input type="text" name="nc" placeholder="Codigo..." required>
        <button type="submit" class="ready-button">Listo</button>
      </form>

      <img class="card-logo" src="../img/Designer (16).png" alt="NearCare">
    </section>
  </main>
</body>
</html>

