
<?php 
require_once __DIR__ . '/../php/paciente-familiar-data.php'; 
?>

<?php
if ($paciente) {

    // ✅ ESTA ES LA SOLUCIÓN REAL
    require_once "conexion.php";

    $id_paciente = $paciente['id_paciente'];

    // ✅ EVENTOS DEL MES
    $queryEventos = "SELECT * FROM eventos 
    WHERE id_paciente = $id_paciente 
    AND MONTH(fecha) = 4 
    AND YEAR(fecha) = 2026";

    $resultEventos = mysqli_query($conn, $queryEventos);

    $eventos = [];

    while ($row = mysqli_fetch_assoc($resultEventos)) {
        $dia = date('j', strtotime($row['fecha']));
        $eventos[$dia][] = $row;
    }
}

function conditionStatusClass($condition) {
    $normalized = strtolower(trim((string)$condition));
    $normalized = str_replace(
        ['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú'],
        ['a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u'],
        $normalized
    );

    if (strpos($normalized, 'grave') !== false || strpos($normalized, 'critico') !== false) {
        return 'condition-danger';
    }

    if (strpos($normalized, 'estable') !== false) {
        return 'condition-stable';
    }

    if (strpos($normalized, 'observacion') !== false || strpos($normalized, 'delicado') !== false || strpos($normalized, 'regular') !== false) {
        return 'condition-warning';
    }

    return '';
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Información del paciente</title>
  <link rel="stylesheet" href="../Css/session-menu.css">
  <link rel="stylesheet" href="../Css/paciente-familiar.css">
  <link rel="stylesheet" href="../css/calendario.css">
  <link rel="stylesheet" href="../Css/paciente-familiar.css?v=10">
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
  <main class="page">
    <header class="navbar">
      <div class="nav-left">
        <a href="index.php" class="back-link" aria-label="Regresar al inicio">&#8249;</a>
        <img class="brand" src="../img/Designer (16).png" alt="NearCare">
      </div>

      <h1 class="page-title">Información del paciente</h1>

      <div class="profile">
        <div class="user-icon" aria-hidden="true"></div>
        <div class="welcome-box">
          <span>Bienvenido</span>
          <div class="toggle" aria-hidden="true"></div>
        </div>
      </div>
    </header>

    <?php if ($isLoggedIn): ?>
      <?php include "../php/menu-lateral.php"; ?>
    <?php endif; ?>

    <section class="content">
      <?php if ($paciente): ?>
        <article class="patient-card">
          <img src="<?php echo e($fotoPaciente); ?>" alt="Foto del paciente">
          <h2><?php echo e($paciente['nombre_completo']); ?></h2>
          <p>Nc<?php echo e($paciente['nc']); ?></p>
          <div class="doctor-name"><?php echo e($paciente['doctor_nombre']); ?></div>
        </article>

        <aside class="side-info">
          <div class="field-group">
            <div class="field-label">Condición del paciente</div>
            <div class="field-value condition-status <?php echo conditionStatusClass($paciente['condicion_paciente']); ?>"><?php echo e($paciente['condicion_paciente']); ?></div>
          </div>

          <div class="field-group">
            <div class="field-label">Género</div>
            <div class="field-value"><?php echo e($paciente['genero']); ?></div>
          </div>
        </aside>

        <div class="lower-row">
          <article class="date-card">
            <div class="section-label">Fecha de ingreso:</div>
            <div class="date-fields">
              <div class="date-box"><?php echo e($diaIngreso); ?></div>
              <span>/</span>
              <div class="date-box"><?php echo e($mesIngreso); ?></div>
              <span>/</span>
              <div class="date-box"><?php echo e($anioIngreso); ?></div>
            </div>
          </article>

          <article class="reason-card">
            <div class="section-label">Motivo de ingreso:</div>
            <div class="reason-value"><?php echo e($paciente['motivo_ingreso']); ?></div>
          </article>
        </div>

        <article class="diagnosis-card">
          <div class="section-label">diagnóstico:</div>
          <div class="diagnosis-box"><?php echo nl2br(e($paciente['diagnostico_medico'])); ?></div>
        </article>

        <article class="calendar-card">
          <div class="section-label">Calendario</div>

          <div class="contenedor">

            <!-- CALENDARIO -->
            <div class="calendario">
              <h3>ABRIL</h3>
              <table>
                <tr>
                  <th>Dom</th><th>Lun</th><th>Mar</th><th>Mié</th>
                  <th>Jue</th><th>Vie</th><th>Sáb</th>
                </tr>

                <?php
                $diasMes = 30;
                $diaSemana = 2; // abril empieza martes

                $contador = 1;

                echo "<tr>";

                for ($i = 0; $i < $diaSemana; $i++) {
                  echo "<td></td>";
                }

                while ($contador <= $diasMes) {

                  if (($diaSemana % 7) == 0) {
                    echo "</tr><tr>";
                  }

                  echo "<td>";
                  echo "<strong>$contador</strong>";

                  if (isset($eventos[$contador])) {
                    foreach ($eventos[$contador] as $evento) {
                      echo "<div class='evento'>";
                      echo $evento['titulo'];
                      echo "</div>";
                    }
                  }

                  echo "</td>";

                  $contador++;
                  $diaSemana++;
                }

                echo "</tr>";
                ?>

              </table>
            </div>

            <!-- LISTA DE EVENTOS -->
            <div class="lista-eventos">
              <h4>Eventos</h4>

              <?php
              $queryLista = "SELECT * FROM eventos WHERE id_paciente = $id_paciente ORDER BY fecha ASC";
              $resultLista = mysqli_query($conn, $queryLista);

              while ($ev = mysqli_fetch_assoc($resultLista)) {
                echo "<div class='item'>";
                echo "<strong>" . date('d/m/Y', strtotime($ev['fecha'])) . "</strong><br>";
                echo $ev['titulo'] . "<br>";
                echo "<small>" . $ev['descripcion'] . "</small>";
                echo "</div>";
              }
              ?>
            </div>

          </div>
        </article>

      <?php else: ?>
        <div class="message-card">
          <?php echo e($mensaje); ?>
          <br>
          <a href="registro2.php">Volver a ingresar el codigo</a>
        </div>
      <?php endif; ?>
    </section>
  </main>
  <?php if ($isLoggedIn): ?>
    <script src="../menu.js"></script>
  <?php endif; ?>
</body>
</html>
