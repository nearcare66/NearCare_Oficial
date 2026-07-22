<?php
session_start();
require_once __DIR__ . '/../php/saludo.php';

if (!isset($_SESSION['id_doctor'])) {
    header("Location: login-form.php");
    exit();
}

require_once __DIR__ . '/conexion.php';

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

$mensajeError = '';
$mensajeExito = isset($_GET['actualizado']) ? 'Los datos de tu perfil se actualizaron correctamente.' : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_perfil'])) {
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $especialidad = trim($_POST['especialidad'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');

    if ($nombre === '' || $correo === '' || $especialidad === '' || $telefono === '') {
        $mensajeError = 'Completa todos los campos del perfil.';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensajeError = 'Ingresa un correo electrónico válido.';
    } else {
        $stmtActualizar = $conn->prepare(
            'UPDATE doctores SET nombre = ?, correo = ?, especialidad = ?, telefono = ? WHERE id_doctor = ?'
        );

        if (!$stmtActualizar) {
            $mensajeError = 'No pudimos preparar la actualización del perfil.';
        } else {
            $idDoctorSesion = (int) $_SESSION['id_doctor'];
            $stmtActualizar->bind_param('ssssi', $nombre, $correo, $especialidad, $telefono, $idDoctorSesion);

            if ($stmtActualizar->execute()) {
                $_SESSION['nombre'] = $nombre;
                $stmtActualizar->close();
                header('Location: perfil.php?actualizado=1');
                exit();
            }

            $mensajeError = $stmtActualizar->errno === 1062
                ? 'Ese correo electrónico ya pertenece a otra cuenta.'
                : 'No pudimos actualizar el perfil. Inténtalo nuevamente.';
            $stmtActualizar->close();
        }
    }
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
  <link rel="stylesheet" href="../Css/botones-globales.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../Css/dark-mode.css?v=<?php echo time(); ?>">
  <script src="../dark-mode.js?v=<?php echo time(); ?>" defer></script>
    <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon_io%20%283%29/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon_io%20%283%29/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon_io%20%283%29/favicon-16x16.png">
    <link rel="shortcut icon" href="../img/favicon_io%20%283%29/favicon.ico">
    <link rel="manifest" href="../img/favicon_io%20%283%29/site.webmanifest">
</head>
<body class="profile-page doctor-profile-page">
  <?php include "menu_doctor.php"; ?>

  <nav class="navbar">
    <div class="nav-left">
      <button class="menu-icon" type="button" onclick="abrirMenu()" aria-label="Abrir menú">☰</button>
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
        <div class="profile-edit-heading">
          <div>
            <span class="profile-eyebrow">Información de la cuenta</span>
            <h3>Edita tus datos</h3>
          </div>
          <span class="profile-edit-badge">Perfil médico</span>
        </div>

        <?php if ($mensajeExito !== ''): ?>
          <div class="profile-alert profile-alert-success" role="status"><?php echo e($mensajeExito); ?></div>
        <?php endif; ?>

        <?php if ($mensajeError !== ''): ?>
          <div class="profile-alert profile-alert-error" role="alert"><?php echo e($mensajeError); ?></div>
        <?php endif; ?>

        <form method="POST" class="profile-edit-form">
          <label class="profile-input-group">
            <span>Nombre completo</span>
            <input type="text" name="nombre" value="<?php echo e($_POST['nombre'] ?? $doctor['nombre']); ?>" autocomplete="name" required>
          </label>

          <label class="profile-input-group">
            <span>Correo electrónico</span>
            <input type="email" name="correo" value="<?php echo e($_POST['correo'] ?? $doctor['correo']); ?>" autocomplete="email" required>
          </label>

          <label class="profile-input-group">
            <span>Especialidad</span>
            <input type="text" name="especialidad" value="<?php echo e($_POST['especialidad'] ?? $doctor['especialidad']); ?>" required>
          </label>

          <label class="profile-input-group">
            <span>Teléfono</span>
            <input type="tel" name="telefono" value="<?php echo e($_POST['telefono'] ?? $doctor['telefono']); ?>" autocomplete="tel" required>
          </label>

          <div class="profile-form-actions">
            <p>Tus cambios se mostrarán en tu cuenta de doctor.</p>
            <button type="submit" name="guardar_perfil" value="1">Guardar cambios</button>
          </div>
        </form>
      </div>
    </section>
  </main>

</body>
</html>
