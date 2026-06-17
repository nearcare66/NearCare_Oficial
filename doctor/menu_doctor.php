<?php
if(!isset($_SESSION['id_doctor'])){
    header("Location: login.html");
    exit();
}
?>

<div class="side-menu" id="sideMenu">

    <div class="menu-logo">
        <img src="../img/Designer (16).png" alt="NearCare">
    </div>

    <a href="pacientes.php" class="active">Pacientes</a>

    <a href="../Comentarios.php">Comentarios</a>

    <hr>

    <a href="agregar_paciente.php">Agregar paciente</a>

    <a href="logout.php">Cerrar sesión</a>

</div>