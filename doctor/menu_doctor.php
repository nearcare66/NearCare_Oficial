<?php
if (!isset($_SESSION['id_doctor'])) {
    header("Location: login-form.php");
    exit();
}

$currentDoctorPage = basename($_SERVER['PHP_SELF']);
?>

<div class="doctor-menu-overlay" id="doctorMenuOverlay" aria-hidden="true"></div>

<aside class="side-menu" id="sideMenu" aria-hidden="true">
    <div class="menu-logo">
        <img src="../img/Designer (16).png" alt="NearCare">
    </div>

    <a href="../index.php">Inicio</a>
    <a href="pacientes.php" class="<?php echo $currentDoctorPage === 'pacientes.php' ? 'active' : ''; ?>">Pacientes</a>
    <a href="perfil.php" class="<?php echo $currentDoctorPage === 'perfil.php' ? 'active' : ''; ?>">Ver perfil</a>
    <a href="../Comentarios.php">Comentarios</a>

    <hr>

    <a href="agregar_paciente.php" class="<?php echo $currentDoctorPage === 'agregar_paciente.php' ? 'active' : ''; ?>">Agregar paciente</a>
    <button class="side-menu-theme-toggle" type="button" data-dark-mode-toggle aria-pressed="false" aria-label="Activar modo oscuro" title="Modo oscuro">
        <svg class="theme-icon theme-icon-moon" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 15.2A8.5 8.5 0 0 1 8.8 3.5 9 9 0 1 0 20.5 15.2Z"/></svg>
        <svg class="theme-icon theme-icon-sun" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 7a5 5 0 1 0 0 10 5 5 0 0 0 0-10Zm0-5 1 2h-2l1-2Zm0 18 1 2h-2l1-2ZM2 12l2-1v2l-2-1Zm18 0 2-1v2l-2-1ZM4.9 4.9l2.1.7-1.4 1.4-.7-2.1Zm12.1 12.1 2.1.7-.7-2.1-1.4 1.4Zm2.1-12.1-.7 2.1L17 5.6l2.1-.7ZM7 17l-2.1.7.7-2.1L7 17Z"/></svg>
        <span class="sr-only" data-dark-mode-label>Activar modo oscuro</span>
    </button>
    <a class="logout-btn" href="logout.php">Cerrar sesión</a>
</aside>

<script>
(function () {
    const menu = document.getElementById('sideMenu');
    const overlay = document.getElementById('doctorMenuOverlay');

    function setDoctorMenu(open) {
        menu.classList.toggle('show', open);
        overlay.classList.toggle('show', open);
        document.body.classList.toggle('doctor-menu-open', open);
        menu.setAttribute('aria-hidden', String(!open));
        overlay.setAttribute('aria-hidden', String(!open));

        document.querySelectorAll('[aria-controls="sideMenu"]').forEach(function (button) {
            button.setAttribute('aria-expanded', String(open));
        });
    }

    window.abrirMenu = function () {
        setDoctorMenu(!menu.classList.contains('show'));
    };

    window.cerrarMenu = function () {
        setDoctorMenu(false);
    };

    overlay.addEventListener('click', window.cerrarMenu);

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            window.cerrarMenu();
        }
    });
})();
</script>
