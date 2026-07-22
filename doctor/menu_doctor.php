<?php
if (!isset($_SESSION['id_doctor'])) {
    header("Location: login-form.php");
    exit();
}

$currentDoctorPage = basename($_SERVER['PHP_SELF']);
?>

<div class="side-menu" id="sideMenu">
    <div class="menu-logo">
        <img src="../img/Designer (16).png" alt="NearCare">
    </div>

    <a href="pacientes.php" class="<?php echo $currentDoctorPage === 'pacientes.php' ? 'active' : ''; ?>">Pacientes</a>
    <a href="perfil.php" class="<?php echo $currentDoctorPage === 'perfil.php' ? 'active' : ''; ?>">Ver perfil</a>
    <a href="../Comentarios.php">Comentarios</a>

    <hr>

    <a href="agregar_paciente.php" class="<?php echo $currentDoctorPage === 'agregar_paciente.php' ? 'active' : ''; ?>">Agregar paciente</a>
    <a href="logout.php">Cerrar sesión</a>
</div>
