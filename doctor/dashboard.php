<?php
session_start();

if(!isset($_SESSION['id_doctor'])){
    header("Location: login-form.php");
    exit();
}

$nombre = $_SESSION['nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Doctor</title>
    <link rel="stylesheet" href="css/style.css?v=4">
  <link rel="stylesheet" href="../Css/botones-globales.css?v=1">
</head>
<body class="doctor-dashboard-page">

<?php include("menu_doctor.php"); ?>

<nav class="navbar">
    <div class="left-navbar">
      <button class="menu-icon" onclick="abrirMenu()">☰</button>

        <div class="logo">
            <img src="../img/Designer (16).png" alt="NearCare">
        </div>
    </div>

    <h1><?php echo htmlspecialchars($nombre); ?></h1>
</nav>

<div class="circle circle1"></div>
<div class="circle circle2"></div>
<div class="circle circle3"></div>
<div class="circle circle4"></div>
<div class="circle circle5"></div>

<main class="dashboard-main">
    <section class="welcome-card">
        <h2>Bienvenida, <?php echo htmlspecialchars($nombre); ?></h2>
    </section>

    <div class="menu-doctor">
        <a href="pacientes.php" class="btn-paciente">
            <span>Pacientes</span>
        </a>
        <a href="../Comentarios.php" class="btn-comentarios">
            <span>Comentarios</span>
        </a>
    </div>
</main>

<script>
function abrirMenu(){
    document.getElementById("sideMenu").classList.toggle("show");
}
</script>

</body>
</html>
