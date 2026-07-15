<<<<<<< HEAD
<?php require_once __DIR__ . '/php/registro2-data.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NearCare Registro Familiar</title>
  <link rel="stylesheet" href="Css/registro2.css">
  <link rel="stylesheet" href="Css/botones-globales.css?v=2">
</head>
<body>
  <main class="page">
    <header class="navbar">
      <div class="nav-left">
        <a href="doctor-familiar.php" class="back-arrow">&#8249;</a>
        <img class="brand" src="img/Designer (16).png" alt="NearCare">
      </div>

      <div class="family-pill">Familiar</div>

      <div class="profile">
        <div class="user-icon" aria-hidden="true"></div>
        <div class="welcome-box">
          <span>Bienvenido</span>
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
      <h1>Bienvenido</h1>
      <div class="welcome-name"><?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?></div>

      <form class="welcome-form" action="paciente-familiar.php" method="GET">
        <input type="number" name="id_doctor" placeholder="ID del doctor..." min="1">
        <input type="text" name="nc" placeholder="Código..." required>
        <button type="submit" class="ready-button">Listo</button>
      </form>

      <img class="card-logo" src="img/Designer (16).png" alt="NearCare">
    </section>
  </main>
</body>
</html>

<?php
$target = 'familiar/registro2.php';
if (!empty($_SERVER['QUERY_STRING'])) {
    $target .= '?' . $_SERVER['QUERY_STRING'];
}
header('Location: ' . $target);
exit;
?>

