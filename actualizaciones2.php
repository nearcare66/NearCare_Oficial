<?php
session_start();
require_once __DIR__ . '/doctor/conexion.php';

$isLoggedIn = isset($_SESSION['usuario_id']);

$conn->set_charset("utf8mb4");

$sqlNotificaciones = "CREATE TABLE IF NOT EXISTS actualizaciones_pacientes (
    id_actualizacion INT AUTO_INCREMENT PRIMARY KEY,
    id_paciente INT NOT NULL,
    id_doctor INT NOT NULL,
    paciente_nombre VARCHAR(150) NOT NULL,
    doctor_nombre VARCHAR(100) NOT NULL,
    condicion_anterior VARCHAR(100) DEFAULT NULL,
    condicion_nueva VARCHAR(100) DEFAULT NULL,
    mensaje TEXT NOT NULL,
    creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
$conn->query($sqlNotificaciones);

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function fechaNotificacion($fecha) {
    $timestamp = strtotime($fecha);
    return $timestamp ? date('d/m/Y h:i A', $timestamp) : '';
}

function mayusculas($value) {
    return function_exists('mb_strtoupper')
        ? mb_strtoupper((string)$value, 'UTF-8')
        : strtoupper((string)$value);
}

$busqueda = trim($_GET['buscar'] ?? '');
$idPacienteSesion = (int)($_SESSION['paciente_id'] ?? 0);

if (!$isLoggedIn) {
    header("Location: loging.php");
    exit();
}

if ($idPacienteSesion <= 0) {
    $actualizaciones = null;
    $totalActualizaciones = 0;
} elseif ($busqueda !== '') {
    $buscarParam = '%' . $busqueda . '%';
    $sql = "SELECT * FROM actualizaciones_pacientes
            WHERE id_paciente = ?
            AND (paciente_nombre LIKE ? OR doctor_nombre LIKE ? OR mensaje LIKE ?)
            ORDER BY creado_en DESC
            LIMIT 30";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $idPacienteSesion, $buscarParam, $buscarParam, $buscarParam);
} else {
    $sql = "SELECT * FROM actualizaciones_pacientes
            WHERE id_paciente = ?
            ORDER BY creado_en DESC
            LIMIT 30";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idPacienteSesion);
}

if ($idPacienteSesion > 0) {
    $stmt->execute();
    $actualizaciones = $stmt->get_result();
    $totalActualizaciones = $actualizaciones->num_rows;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>NearCare - Notificaciones</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="Css/styless.css">
  <link rel="stylesheet" href="Css/session-menu.css">
  <link rel="stylesheet" href="Css/botones-globales.css?v=1">
</head>
<body>

  <header class="navbar">
    <?php if ($isLoggedIn): ?>
      <button class="menu-icon" type="button" aria-label="Abrir menu" aria-controls="sideMenu" aria-expanded="false">
        &#9776;
      </button>
    <?php endif; ?>

    <a href="index.php" class="back-arrow">&#8592;</a>

    <div class="logo">
      <img src="img/Designer (16).png" alt="logo">
    </div>

    <form class="search-box" method="GET" action="actualizaciones2.php">
      <input type="text" name="buscar" placeholder="Buscar paciente..." value="<?php echo e($busqueda); ?>">
    </form>

    <div class="notifications">
      &#128276;
      <span><?php echo $totalActualizaciones; ?></span>
    </div>

  </header>

  <?php if ($isLoggedIn): ?>
    <?php include "php/menu-lateral.php"; ?>
  <?php endif; ?>

  <div class="circle circle1"></div>
  <div class="circle circle2"></div>
  <div class="circle circle3"></div>
  <div class="circle circle4"></div>
  <div class="circle circle5"></div>

  <div class="notifications-section">

    <h1>Notificaciones</h1>

    <?php if ($idPacienteSesion <= 0): ?>
      <div class="notification-card">
        <div class="icon">&#128276;</div>
        <div class="notification-text">
          <h2>INGRESA EL CODIGO DEL PACIENTE</h2>
          <p>Para ver actualizaciones primero debes entrar con el codigo Nc del paciente.</p>
        </div>
      </div>
    <?php elseif ($totalActualizaciones > 0): ?>
      <?php while ($actualizacion = $actualizaciones->fetch_assoc()): ?>
        <div class="notification-card">
          <div class="icon">
            &#128100;
          </div>

          <div class="notification-text">
            <h2>
              ESTADO DE ACTUALIZACION DEL PACIENTE, <?php echo e(mayusculas($actualizacion['paciente_nombre'])); ?>
            </h2>

            <p>
              <?php echo e($actualizacion['mensaje']); ?>
              <br>
              <small><?php echo e(fechaNotificacion($actualizacion['creado_en'])); ?></small>
            </p>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="notification-card">
        <div class="icon">&#128276;</div>
        <div class="notification-text">
          <h2>NO HAY NOTIFICACIONES</h2>
          <p>Todavia no se han registrado cambios en pacientes.</p>
        </div>
      </div>
    <?php endif; ?>

  </div>

  <?php if ($isLoggedIn): ?>
    <script src="menu.js"></script>
  <?php endif; ?>
</body>
</html>
