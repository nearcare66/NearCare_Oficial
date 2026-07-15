<?php if (isset($_SESSION['usuario_id'])): ?>
  <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    $scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $inFamiliarFolder = strpos($scriptPath, '/familiar/') !== false;
    $basePath = $inFamiliarFolder ? '../' : '';
    $isFamilySession = isset($_SESSION['usuario_id']) && !isset($_SESSION['id_doctor']);

    $isInicio = !$inFamiliarFolder && $currentPage === 'index.php';
    $isFamiliarDoctor = !$isFamilySession && (($inFamiliarFolder && $currentPage === 'index.php')
        || in_array($currentPage, ['loging.php', 'register.php', 'registro2.php', 'paciente-familiar.php', 'loging-o-registrer.php'], true));
    $isPaciente = $isFamilySession && in_array($currentPage, ['registro2.php', 'paciente-familiar.php'], true);
    $patientLink = !empty($_SESSION['paciente_nc'])
        ? $basePath . 'familiar/paciente-familiar.php'
        : $basePath . 'familiar/registro2.php';
    $isSobre = $currentPage === 'sobre-nosotros.php';
    $isActualizaciones = $currentPage === 'actualizaciones2.php';
    $isComentarios = $currentPage === 'Comentarios.php';
    $isPerfil = $inFamiliarFolder && $currentPage === 'perfil.php';
  ?>
  <div class="menu-overlay" data-close-menu></div>

  <aside class="side-menu" id="sideMenu" aria-hidden="true">
    <div class="side-menu-strip"></div>
    <div class="side-menu-content">
<<<<<<< HEAD
      <img class="side-menu-logo" src="img/Designer (16).png" alt="NearCare">
      <a href="index.php" class="<?php echo $isInicio ? 'active' : ''; ?>">Inicio</a>
      <a href="doctor-familiar.php" class="<?php echo $isFamiliarDoctor ? 'active' : ''; ?>">Familiar o doctor</a>
      <a href="#" class="<?php echo $isFamiliar ? 'active' : ''; ?>">Familiar</a>
      <a href="#">Doctor</a>
      <hr>
      <a href="sobre-nosotros.php" class="<?php echo $isSobre ? 'active' : ''; ?>">Sobre nosotros</a>
      <a href="actualizaciones2.php" class="<?php echo $isActualizaciones ? 'active' : ''; ?>">Actualizaciones</a>
      <a href="Comentarios.php" class="<?php echo $isComentarios ? 'active' : ''; ?>">Comentarios</a>
     
=======

      <?php if ($isFamilySession): ?>
        <img class="side-menu-logo" src="<?php echo $basePath; ?>img/Designer (16).png" alt="NearCare">
        <a href="<?php echo $patientLink; ?>" class="<?php echo $isPaciente ? 'active' : ''; ?>">Paciente</a>
        <a href="<?php echo $basePath; ?>familiar/perfil.php" class="<?php echo $isPerfil ? 'active' : ''; ?>">Ver perfil</a>
        <a href="<?php echo $basePath; ?>actualizaciones2.php" class="<?php echo $isActualizaciones ? 'active' : ''; ?>">Actualizaciones</a>
        <a href="<?php echo $basePath; ?>Comentarios.php" class="<?php echo $isComentarios ? 'active' : ''; ?>">Comentarios</a>
        <hr>
        <a href="<?php echo $basePath; ?>index.php" class="<?php echo $isInicio ? 'active' : ''; ?>">Inicio</a>
        <a href="<?php echo $basePath; ?>sobre-nosotros.php" class="<?php echo $isSobre ? 'active' : ''; ?>">Sobre nosotros</a>
        <a href="<?php echo $basePath; ?>php/logout.php">Cerrar sesion</a>
      <?php else: ?>
        <img class="side-menu-logo" src="<?php echo $basePath; ?>img/Designer (16).png" alt="NearCare">
        <a href="<?php echo $basePath; ?>index.php" class="<?php echo $isInicio ? 'active' : ''; ?>">Inicio</a>
        <a href="<?php echo $basePath; ?>familiar/index.php" class="<?php echo $isFamiliarDoctor ? 'active' : ''; ?>">Familiar o doctor</a>
        <a href="<?php echo $basePath; ?>doctor/dashboard.php">Doctor</a>
        <hr>
        <a href="<?php echo $basePath; ?>sobre-nosotros.php" class="<?php echo $isSobre ? 'active' : ''; ?>">Sobre nosotros</a>
        <a href="<?php echo $basePath; ?>actualizaciones2.php" class="<?php echo $isActualizaciones ? 'active' : ''; ?>">Actualizaciones</a>
        <a href="<?php echo $basePath; ?>Comentarios.php" class="<?php echo $isComentarios ? 'active' : ''; ?>">Comentarios</a>
      <?php endif; ?>
>>>>>>> 3c87d6380d3b47dea9b1b3661d73f0dfefad2172
    </div>
  </aside>
<?php endif; ?>
