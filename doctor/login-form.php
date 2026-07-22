<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_SESSION['id_doctor'])) {
    header("Location: dashboard.php");
    exit();
}

$loginError = $_SESSION['doctor_login_error'] ?? '';
$loginCorreo = $_SESSION['doctor_login_correo'] ?? '';
unset($_SESSION['doctor_login_error'], $_SESSION['doctor_login_correo']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Doctor</title>
    <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="../Css/botones-globales.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../Css/dark-mode.css?v=<?php echo time(); ?>">
  <script src="../dark-mode.js?v=<?php echo time(); ?>" defer></script>
    <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon_io%20%283%29/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon_io%20%283%29/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon_io%20%283%29/favicon-16x16.png">
    <link rel="shortcut icon" href="../img/favicon_io%20%283%29/favicon.ico">
    <link rel="manifest" href="../img/favicon_io%20%283%29/site.webmanifest">
</head>
<body class="nearcare-loading">

<nav class="navbar">
    <div class="left-navbar">
        <a href="../familiar/index.php" class="back-arrow">&#8249;</a>

        <div class="logo">
            <img src="../img/Designer (16).png" alt="NearCare">
        </div>
    </div>

    <div class="role">Doctor</div>

</nav>

<div class="circle circle1"></div>
<div class="circle circle2"></div>
<div class="circle circle3"></div>
<div class="circle circle4"></div>

<div class="main-container">

    <div class="form-container login-container">

        <h2>INICIAR SESIÓN</h2>

        <div class="content-row">

            <div class="image-panel">
                <img src="img/doctores2.jpg" alt="Doctor">
            </div>

            <form action="login.php" method="POST" class="register-form login-form">

                <input type="email" name="correo" placeholder="Correo electrónico" value="<?php echo htmlspecialchars($loginCorreo); ?>" required>

                <input type="password" name="password" placeholder="Contraseña" required>

                <p>
                    No tienes cuenta?
                    <a href="register-form.php">Regístrate</a>
                </p>

                <button type="submit">Iniciar sesión</button>

                <?php if ($loginError !== ''): ?>
                    <div class="form-error" role="alert"><?php echo htmlspecialchars($loginError); ?></div>
                <?php endif; ?>

            </form>

        </div>

    </div>

</div>

</body>
</html>
