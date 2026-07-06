<?php
session_start();
require_once __DIR__ . '/../php/saludo.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: loging.php");
    exit();
}

require_once __DIR__ . '/../conexion.php';

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

$familiar = [
    'nombre' => $_SESSION['usuario'] ?? $_SESSION['registro_nombre'] ?? 'Familiar',
    'correo' => $_SESSION['correo'] ?? 'No registrado',
    'codigo' => 'Protegido',
];

$stmt = $conexion->prepare("SELECT nombre, correo, codigo FROM usuarios_nuevos WHERE id = ? LIMIT 1");
if ($stmt) {
    $stmt->bind_param("i", $_SESSION['usuario_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $familiar = array_merge($familiar, array_filter($row, fn($value) => $value !== null && $value !== ''));
    }
    $stmt->close();
}

$saludo = nearcare_saludo($familiar['nombre']);
$initial = strtoupper(substr(trim($familiar['nombre']), 0, 1) ?: 'F');
$codigoVisible = $familiar['codigo'] !== 'Protegido' ? str_repeat('*', max(4, strlen((string)$familiar['codigo']))) : $familiar['codigo'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil familiar</title>
  <link rel="stylesheet" href="../Css/session-menu.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../Css/perfil.css?v=<?php echo time(); ?>">
</head>
<body class="profile-page family-profile-page">
  <nav class="navbar">
    <div class="nav-left">
      <button class="menu-icon" type="button" aria-label="Abrir menu" aria-expanded="false">☰</button>
      <img class="brand" src="../img/Designer (16).png" alt="NearCare">
    </div>

    <h1 class="page-title">Mi perfil</h1>
    <div class="profile-chip"><?php echo e($saludo); ?></div>
  </nav>

  <?php include __DIR__ . "/../php/menu-lateral.php"; ?>

  <main class="profile-main">
    <section class="profile-card">
      <div class="profile-header">
        <div class="profile-avatar" aria-hidden="true"><?php echo e($initial); ?></div>
        <div>
          <h2><?php echo e($familiar['nombre']); ?></h2>
          <p>Perfil familiar</p>
        </div>
      </div>

      <div class="profile-info">
        <div class="profile-field">
          <span>Nombre</span>
          <strong><?php echo e($familiar['nombre']); ?></strong>
        </div>
        <div class="profile-field">
          <span>Correo</span>
          <strong><?php echo e($familiar['correo']); ?></strong>
        </div>
        <div class="profile-field">
          <span>Codigo de acceso</span>
          <strong><?php echo e($codigoVisible); ?></strong>
        </div>
        <div class="profile-field">
          <span>Cuenta</span>
          <strong>Familiar</strong>
        </div>
        <p class="profile-note">Desde este perfil puedes revisar los datos principales de tu cuenta familiar.</p>
      </div>
    </section>
  </main>

  <script src="../menu.js"></script>
</body>
</html>
