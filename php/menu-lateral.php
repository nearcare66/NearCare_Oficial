<?php if (isset($_SESSION['usuario_id'])): ?>
  <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    $isInicio = $currentPage === 'index.php';
    $isFamiliarDoctor = in_array($currentPage, ['doctor-familiar.php', 'loging.php', 'register.php', 'loging-o-registrer.php'], true);
    $isFamiliar = in_array($currentPage, ['loging.php', 'register.php'], true);
    $isSobre = $currentPage === 'sobre-nosotros.php';
    $isActualizaciones = $currentPage === 'actualizaciones2.php';
    $isComentarios = $currentPage === 'Comentarios.php';
  ?>
  <div class="menu-overlay" data-close-menu></div>

  <aside class="side-menu" id="sideMenu" aria-hidden="true">
    <div class="side-menu-strip"></div>
    <div class="side-menu-content">
      <img class="side-menu-logo" src="img/Designer (16).png" alt="NearCare">
      <a href="index.php" class="<?php echo $isInicio ? 'active' : ''; ?>">Inicio</a>
      <a href="doctor-familiar.php" class="<?php echo $isFamiliarDoctor ? 'active' : ''; ?>">Familiar o doctor</a>
      <a href="#" class="<?php echo $isFamiliar ? 'active' : ''; ?>">Familiar</a>
      <a href="#">Doctor</a>
      <hr>
      <a href="sobre-nosotros.php" class="<?php echo $isSobre ? 'active' : ''; ?>">Sobre nosotros</a>
      <a href="actualizaciones2.php" class="<?php echo $isActualizaciones ? 'active' : ''; ?>">Actualizaciones</a>
      <a href="Comentarios.php" class="<?php echo $isComentarios ? 'active' : ''; ?>">Comentarios</a>
    </div>
  </aside>
<?php endif; ?>
