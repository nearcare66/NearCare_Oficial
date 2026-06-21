<?php
session_start();

if(!isset($_SESSION['id_doctor'])){
    header("Location: login.html");
    exit();
}

$nombre = $_SESSION['nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Doctor</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

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

<div class="welcome-card">
    <h2>Bienvenida, <?php echo htmlspecialchars($nombre); ?></h2>
    <p>Gestiona pacientes y comentarios desde tu panel.</p>
</div>

<div class="menu-doctor">
    <a href="pacientes.php" class="btn-paciente">Pacientes</a>
    <a href="comentarios.php" class="btn-comentarios">Comentarios</a>
</div>

<script>
function abrirMenu(){
    document.getElementById("sideMenu").classList.toggle("show");
}
</script>

</body>
</html>