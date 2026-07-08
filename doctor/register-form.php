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
?>
<!DOCTYPE html>
<html lang="es"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Doctor</title>
    <link rel="stylesheet" href="css/style.css">
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

<nav class="navbar">
    <div class="left-navbar">
        <a href="../familiar/index.php" class="back-arrow">&#8249;</a>

        <div class="logo">
            <img src="../img/Designer (16).png" alt="NearCare">
        </div>
    </div>

    <div class="role">Doctor</div>

    <div class="welcome">
        Bienvenido
    </div>
</nav>

<div class="circle circle1"></div>
<div class="circle circle2"></div>
<div class="circle circle3"></div>
<div class="circle circle4"></div>

<div class="main-container">
    <div class="form-container">

        <h2>REGISTRO DOCTOR</h2>

        <div class="content-row">

            <div class="image-panel">
                <img src="img/doctores.jpg" alt="Doctor">
            </div>

            <form action="register.php" method="POST" class="register-form">
                <input type="text" name="nombre" placeholder="Nombre completo" required>
                <input type="email" name="correo" placeholder="Correo electronico" required>
                <input type="text" name="especialidad" placeholder="Especialidad" required>
                <input type="text" name="telefono" placeholder="Telefono">
                <input type="password" name="password" placeholder="Contrasena" required>
                <input type="password" name="confirmar_password" placeholder="Confirmar contrasena" required>

                <button type="submit">Registrarme</button>
            </form>

        </div>

    </div>
</div>
</body>
</html>
