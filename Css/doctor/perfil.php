<?php
session_start();
require_once __DIR__ . '/../../php/saludo.php';

if (!isset($_SESSION['id_doctor'])) {
    header("Location: login-form.php");
    exit();
}

require_once __DIR__ . '/conexion.php';

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

$doctor = [
    'nombre' => $_SESSION['nombre'] ?? 'Doctor',
    'correo' => 'No registrado',
    'especialidad' => 'No registrada',
    'telefono' => 'No registrado',
];

$stmt = $conn->prepare("SELECT nombre, correo, especialidad, telefono FROM doctores WHERE id_doctor = ? LIMIT 1");
if ($stmt) {
    $stmt->bind_param("i", $_SESSION['id_doctor']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $doctor = array_merge($doctor, array_filter($row, fn($value) => $value !== null && $value !== ''));
    }
    $stmt->close();
}

$saludo = nearcare_saludo($doctor['nombre']);
$initial = strtoupper(substr(trim($doctor['nombre']), 0, 1) ?: 'D');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil del doctor</title>
  <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../Css/perfil.css?v=<?php echo time(); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="../../img/favicon_io%20%283%29/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../img/favicon_io%20%283%29/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../img/favicon_io%20%283%29/favicon-16x16.png">
    <link rel="shortcut icon" href="../../img/favicon_io%20%283%29/favicon.ico">
    <link rel="manifest" href="../../img/favicon_io%20%283%29/site.webmanifest">
</head>
<body class="profile-page doctor-profile-page">
  <?php include "menu_doctor.php"; ?>

  <nav class="navbar">
    <div class="nav-left">
      <button class="menu-icon" type="button" onclick="abrirMenu()" aria-label="Abrir menu">☰</button>
      <img class="brand" src="../img/Designer (16).png" alt="NearCare">
    </div>

    <h1 class="page-title">Mi perfil</h1>
    <div class="profile-chip"><?php echo e($saludo); ?></div>
  </nav>

  <main class="profile-main">
    <section class="profile-card">
      <div class="profile-header">
        <div class="profile-avatar" aria-hidden="true"><?php echo e($initial); ?></div>
        <div>
          <h2><?php echo e($doctor['nombre']); ?></h2>
          <p>Perfil de doctor</p>
        </div>
      </div>

      <div class="profile-info">
        <div class="profile-field">
          <span>Nombre</span>
          <strong><?php echo e($doctor['nombre']); ?></strong>
        </div>
        <div class="profile-field">
          <span>Correo</span>
          <strong><?php echo e($doctor['correo']); ?></strong>
        </div>
        <div class="profile-field">
          <span>Especialidad</span>
          <strong><?php echo e($doctor['especialidad']); ?></strong>
        </div>
        <div class="profile-field">
          <span>Telefono</span>
          <strong><?php echo e($doctor['telefono']); ?></strong>
        </div>
        <p class="profile-note">Estos son los datos visibles de tu cuenta de doctor.</p>
      </div>
    </section>
  </main>

  <script>
  function abrirMenu() {
    document.getElementById("sideMenu").classList.toggle("show");
  }
  </script>
</body>
</html>
