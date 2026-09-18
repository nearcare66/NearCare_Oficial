<?php
  $nearcareMenuLoggedIn =
      isset($_SESSION['usuario_id']) ||
      isset($_SESSION['id_doctor']) ||
      isset($_SESSION['id_familiar']);
?>
<?php if ($nearcareMenuLoggedIn): ?>
  <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    $scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $inFamiliarFolder = strpos($scriptPath, '/familiar/') !== false;
    $inDoctorFolder = strpos($scriptPath, '/doctor/') !== false;
    $basePath = ($inFamiliarFolder || $inDoctorFolder) ? '../' : '';
    $isFamilySession = !isset($_SESSION['id_doctor']) &&
        (isset($_SESSION['usuario_id']) || isset($_SESSION['id_familiar']));

    $isInicio = !$inFamiliarFolder && $currentPage === 'index.php';
    $isPaciente = $isFamilySession && in_array($currentPage, ['registro2.php', 'paciente-familiar.php'], true);
    $patientLink = !empty($_SESSION['paciente_nc'])
        ? $basePath . 'familiar/paciente-familiar.php'
        : $basePath . 'familiar/registro2.php';
    $isComentarios = $currentPage === 'Comentarios.php';
    $isPerfil = $inFamiliarFolder && $currentPage === 'perfil.php';
  ?>
  <div class="menu-overlay" data-close-menu></div>

  <aside class="side-menu" id="sideMenu" aria-hidden="true">
    <div class="side-menu-strip"></div>
    <div class="side-menu-content">

      <?php if ($isFamilySession): ?>
        <img class="side-menu-logo" src="<?php echo $basePath; ?>img/Designer (16).png" alt="NearCare">
        <a href="<?php echo $basePath; ?>index.php" class="<?php echo $isInicio ? 'active' : ''; ?>">Inicio</a>
        <a href="<?php echo $patientLink; ?>" class="<?php echo $isPaciente ? 'active' : ''; ?>">Paciente</a>
        <a href="<?php echo $basePath; ?>familiar/perfil.php" class="<?php echo $isPerfil ? 'active' : ''; ?>">Ver perfil</a>
        <a href="<?php echo $basePath; ?>Comentarios.php" class="<?php echo $isComentarios ? 'active' : ''; ?>">Comentarios</a>
        <hr>
        <button class="side-menu-theme-toggle" type="button" data-dark-mode-toggle aria-pressed="false" aria-label="Activar modo oscuro" title="Modo oscuro">
          <svg class="theme-icon theme-icon-moon" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 15.2A8.5 8.5 0 0 1 8.8 3.5 9 9 0 1 0 20.5 15.2Z"/></svg>
          <svg class="theme-icon theme-icon-sun" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 7a5 5 0 1 0 0 10 5 5 0 0 0 0-10Zm0-5 1 2h-2l1-2Zm0 18 1 2h-2l1-2ZM2 12l2-1v2l-2-1Zm18 0 2-1v2l-2-1ZM4.9 4.9l2.1.7-1.4 1.4-.7-2.1Zm12.1 12.1 2.1.7-.7-2.1-1.4 1.4Zm2.1-12.1-.7 2.1L17 5.6l2.1-.7ZM7 17l-2.1.7.7-2.1L7 17Z"/></svg>
          <span class="sr-only" data-dark-mode-label>Activar modo oscuro</span>
        </button>
        <a class="logout-btn" href="<?php echo $basePath; ?>php/logout.php">Cerrar sesión</a>
      <?php else: ?>
        <img class="side-menu-logo" src="<?php echo $basePath; ?>img/Designer (16).png" alt="NearCare">
        <a href="<?php echo $basePath; ?>index.php" class="<?php echo $isInicio ? 'active' : ''; ?>">Inicio</a>
        <a href="<?php echo $basePath; ?>doctor/dashboard.php">Doctor</a>
        <hr>
        <a href="<?php echo $basePath; ?>Comentarios.php" class="<?php echo $isComentarios ? 'active' : ''; ?>">Comentarios</a>
        <hr>
        <button class="side-menu-theme-toggle" type="button" data-dark-mode-toggle aria-pressed="false" aria-label="Activar modo oscuro" title="Modo oscuro">
          <svg class="theme-icon theme-icon-moon" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 15.2A8.5 8.5 0 0 1 8.8 3.5 9 9 0 1 0 20.5 15.2Z"/></svg>
          <svg class="theme-icon theme-icon-sun" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 7a5 5 0 1 0 0 10 5 5 0 0 0 0-10Zm0-5 1 2h-2l1-2Zm0 18 1 2h-2l1-2ZM2 12l2-1v2l-2-1Zm18 0 2-1v2l-2-1ZM4.9 4.9l2.1.7-1.4 1.4-.7-2.1Zm12.1 12.1 2.1.7-.7-2.1-1.4 1.4Zm2.1-12.1-.7 2.1L17 5.6l2.1-.7ZM7 17l-2.1.7.7-2.1L7 17Z"/></svg>
          <span class="sr-only" data-dark-mode-label>Activar modo oscuro</span>
        </button>
        <a class="logout-btn" href="<?php echo $basePath; ?>php/logout.php">Cerrar sesión</a>
      <?php endif; ?>

    </div>
  </aside>
<?php endif; ?>
