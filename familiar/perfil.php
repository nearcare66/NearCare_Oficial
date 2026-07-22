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

$mensajeError = '';
$mensajeExito = isset($_GET['actualizado']) ? 'Los datos de tu perfil se actualizaron correctamente.' : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_perfil'])) {
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $nuevoCodigo = trim($_POST['nuevo_codigo'] ?? '');

    if ($nombre === '' || $correo === '') {
        $mensajeError = 'Completa el nombre y el correo electrónico.';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensajeError = 'Ingresa un correo electrónico válido.';
    } elseif ($nuevoCodigo !== '' && strlen($nuevoCodigo) < 4) {
        $mensajeError = 'El nuevo código debe tener al menos 4 caracteres.';
    } else {
        $idFamiliar = (int) $_SESSION['usuario_id'];
        $stmtActualizar = null;

        if ($nuevoCodigo !== '') {
            $stmtActualizar = $conexion->prepare(
                'UPDATE usuarios_nuevos SET nombre = ?, correo = ?, codigo = ? WHERE id = ?'
            );
            if ($stmtActualizar) {
                $stmtActualizar->bind_param('sssi', $nombre, $correo, $nuevoCodigo, $idFamiliar);
            }
        } else {
            $stmtActualizar = $conexion->prepare(
                'UPDATE usuarios_nuevos SET nombre = ?, correo = ? WHERE id = ?'
            );
            if ($stmtActualizar) {
                $stmtActualizar->bind_param('ssi', $nombre, $correo, $idFamiliar);
            }
        }

        if (!$stmtActualizar) {
            $mensajeError = 'No pudimos preparar la actualización del perfil.';
        } elseif ($stmtActualizar->execute()) {
            $_SESSION['usuario'] = $nombre;
            $_SESSION['registro_nombre'] = $nombre;
            $_SESSION['correo'] = $correo;
            $stmtActualizar->close();
            header('Location: perfil.php?actualizado=1');
            exit();
        } else {
            $mensajeError = $stmtActualizar->errno === 1062
                ? 'Ese correo electrónico ya pertenece a otra cuenta.'
                : 'No pudimos actualizar el perfil. Inténtalo nuevamente.';
            $stmtActualizar->close();
        }
    }
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
  <link rel="stylesheet" href="../Css/botones-globales.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../Css/dark-mode.css?v=<?php echo time(); ?>">
  <script src="../dark-mode.js?v=<?php echo time(); ?>" defer></script>
    <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon_io%20%283%29/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon_io%20%283%29/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon_io%20%283%29/favicon-16x16.png">
    <link rel="shortcut icon" href="../img/favicon_io%20%283%29/favicon.ico">
    <link rel="manifest" href="../img/favicon_io%20%283%29/site.webmanifest">
</head>
<body class="profile-page family-profile-page">
  <nav class="navbar">
    <div class="nav-left">
      <button class="menu-icon" type="button" aria-label="Abrir menú" aria-expanded="false">☰</button>
      <img class="brand" src="../img/Designer (16).png" alt="NearCare">
    </div>

    <h1 class="page-title">Mi perfíl</h1>
    <div class="profile-chip"><?php echo e($saludo); ?></div>
  </nav>

  <?php include __DIR__ . "/../php/menu-lateral.php"; ?>

  <main class="profile-main">
    <section class="profile-card">
      <div class="profile-header">
        <div class="profile-avatar" aria-hidden="true"><?php echo e($initial); ?></div>
        <div>
          <h2><?php echo e($familiar['nombre']); ?></h2>
          <p>Perfíl familiar</p>
        </div>
      </div>

      <div class="profile-info">
        <div class="profile-edit-heading">
          <div>
            <span class="profile-eyebrow">Información de la cuenta</span>
            <h3>Edita tus datos</h3>
          </div>
          <span class="profile-edit-badge">Cuenta familiar</span>
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
            <input type="text" name="nombre" value="<?php echo e($_POST['nombre'] ?? $familiar['nombre']); ?>" autocomplete="name" required>
          </label>

          <label class="profile-input-group">
            <span>Correo electrónico</span>
            <input type="email" name="correo" value="<?php echo e($_POST['correo'] ?? $familiar['correo']); ?>" autocomplete="email" required>
          </label>

          <label class="profile-input-group profile-input-group-wide">
            <span>Nuevo código de acceso</span>
            <input type="password" name="nuevo_codigo" minlength="4" autocomplete="new-password" placeholder="Déjalo vacío para conservar el código actual">
            <small>Código actual: <?php echo e($codigoVisible); ?></small>
          </label>

          <div class="profile-form-actions">
            <p>El nuevo código solo cambiará si escribes uno.</p>
            <button type="submit" name="guardar_perfil" value="1">Guardar cambios</button>
          </div>
        </form>
      </div>
    </section>
  </main>

  <script src="../menu.js"></script>
</body>
</html>
