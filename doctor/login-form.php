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
    <title>Login Doctor</title>
    <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="../Css/botones-globales.css?v=2">
</head>
<body>

<nav class="navbar">
    <div class="left-navbar">
        <a href="../doctor-familiar.php" class="back-arrow">&#8249;</a>

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

    <div class="form-container login-container">

        <h2>INICIAR SESION</h2>

        <div class="content-row">

            <div class="image-panel">
                <img src="img/doctores2.jpg" alt="Doctor">
            </div>

            <form action="login.php" method="POST" class="register-form login-form">

                <input type="email" name="correo" placeholder="Correo electronico" required>

                <input type="password" name="password" placeholder="Contrasena" required>

                <p>
                    No tienes cuenta?
                    <a href="register-form.php">Registrate</a>
                </p>

                <button type="submit">Iniciar sesion</button>

            </form>

        </div>

    </div>

</div>

</body>
</html>
