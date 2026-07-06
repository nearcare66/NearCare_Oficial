<?php require_once __DIR__ . '/../php/paciente-familiar-data.php'; ?>
<?php
require_once __DIR__ . '/../php/saludo.php';
$saludo = $paciente
    ? nearcare_saludo($paciente['nombre_completo'] ?? '', $paciente['genero'] ?? '')
    : nearcare_saludo($_SESSION['usuario'] ?? $_SESSION['registro_nombre'] ?? '');

if ($paciente) {

    // ✅ ESTA ES LA SOLUCIÓN REAL
    require_once __DIR__ . "/../conexion.php";

    $id_paciente = $paciente['id_paciente'];

    // ✅ MES Y AÑO DINÁMICOS
    $mes = isset($_GET['mes']) ? intval($_GET['mes']) : date('n');
    $anio = isset($_GET['anio']) ? intval($_GET['anio']) : date('Y');

    if($mes < 1){ $mes = 12; $anio--; }
    if($mes > 12){ $mes = 1; $anio++; }

    // ✅ DÍAS DEL MES
    $diasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);

    // ✅ PRIMER DÍA (0=domingo)
    $primerDia = date('w', strtotime("$anio-$mes-01"));

    // ✅ NOMBRE MESES
    $meses = [
    1=>"ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO",
    7=>"JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE"
    ];

    // ✅ EVENTOS DEL MES ACTUAL
    $queryEventos = "SELECT * FROM eventos 
    WHERE id_paciente = $id_paciente 
    AND MONTH(fecha) = $mes 
    AND YEAR(fecha) = $anio";

    $resultEventos = mysqli_query($conn, $queryEventos);

    $eventos = [];

    while ($row = mysqli_fetch_assoc($resultEventos)) {
        $dia = date('j', strtotime($row['fecha']));
        $eventos[$dia][] = $row;
    }

    $sqlNotas = "SELECT np.*, d.nombre AS doctor_nombre
                 FROM notas_paciente np
                 LEFT JOIN doctores d ON d.id_doctor = np.id_doctor
                 WHERE np.id_paciente = ?
                 ORDER BY np.fecha_creacion DESC";
    $stmtNotas = $conn->prepare($sqlNotas);
    $stmtNotas->bind_param("i", $id_paciente);
    $stmtNotas->execute();
    $resultNotas = $stmtNotas->get_result();

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
  <title>Informacion del paciente</title>
  <link rel="stylesheet" href="../Css/botones-globales.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../Css/session-menu.css">
  <link rel="stylesheet" href="../Css/calendario.css">
  <link rel="stylesheet" href="../Css/paciente-familiar.css?v=<?php echo time(); ?>">
</head>
<body class="family-detail-page">
  <main class="page">
    <header class="navbar">
      <div class="nav-left">
        <a href="../index.php" class="back-link family-back-link" aria-label="Volver al inicio">&#8249;</a>
        <img class="brand" src="../img/Designer (16).png" alt="NearCare">
      </div>

      <h1 class="page-title">Informacion del paciente</h1>

      <div class="profile">
        <div class="user-icon" aria-hidden="true"></div>
        <div class="welcome-box">
          <span><?php echo $saludo; ?></span>
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
            <div class="field-label">Condicion del paciente</div>
            <div class="field-value condition-status <?php echo conditionStatusClass($paciente['condicion_paciente']); ?>"><?php echo e($paciente['condicion_paciente']); ?></div>
          </div>

          <div class="field-group">
            <div class="field-label">Genero</div>
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
          <div class="section-label">diagnostico:</div>
          <div class="diagnosis-box"><?php echo nl2br(e($paciente['diagnostico_medico'])); ?></div>
        </article>

        <article class="calendar-card" id="calendario">
          <div class="section-label">Calendario</div>

          <div class="contenedor">

            <!-- CALENDARIO -->
            <div class="calendario">
             <div class="mes-nav">
                <a href="?mes=<?php echo $mes-1; ?>&anio=<?php echo $anio; ?>#calendario">⬅</a>

                <span><?php echo $meses[$mes] . " " . $anio; ?></span>

                <a href="?mes=<?php echo $mes+1; ?>&anio=<?php echo $anio; ?>#calendario">➡</a>
              </div>
              <table>
                <tr>
                  <th>Dom</th><th>Lun</th><th>Mar</th><th>Mié</th>
                  <th>Jue</th><th>Vie</th><th>Sáb</th>
                </tr>

                <?php
                  echo "<tr>";

                  // espacios vacíos
                  for ($i = 0; $i < $primerDia; $i++) {
                      echo "<td></td>";
                  }

                  $diaActual = 1;

                  while ($diaActual <= $diasMes) {

                      if ((($primerDia + $diaActual - 1) % 7) == 0 && $diaActual != 1) {
                          echo "</tr><tr>";
                      }

                      echo "<td>";
                      echo "<strong>$diaActual</strong>";

                      if (isset($eventos[$diaActual])) {
                          foreach ($eventos[$diaActual] as $evento) {
                              echo "<div class='evento'>";
                              echo htmlspecialchars($evento['titulo']);
                              echo "</div>";
                          }
                      }

                      echo "</td>";

                      $diaActual++;
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

        <article class="notas-readonly-card">
          <h3>Notas Medicas</h3>
          <h4 class="notas-subtitle">Notas y audios</h4>

          <div class="historial-notas">
            <?php if (isset($resultNotas) && $resultNotas->num_rows > 0): ?>
              <?php while($nota = $resultNotas->fetch_assoc()): ?>
                <div class="item-nota">
                  <div class="nota-meta">
                    <strong><?php echo e($nota['doctor_nombre'] ?: $paciente['doctor_nombre']); ?></strong>
                    <small><?php echo date("d/m/Y H:i", strtotime($nota['fecha_creacion'])); ?></small>
                  </div>

                  <?php if ($nota['tipo'] === 'texto'): ?>
                    <p><?php echo nl2br(e($nota['nota'])); ?></p>
                  <?php else: ?>
                    <?php $audioUrl = '../doctor/audio_nota.php?id=' . (int)$nota['id_nota']; ?>
                    <audio controls preload="metadata">
                      <source src="<?php echo e($audioUrl); ?>" type="audio/webm">
                      Tu navegador no soporta audio.
                    </audio>
                    <a href="<?php echo e($audioUrl); ?>" target="_blank" rel="noopener">Abrir audio</a>
                  <?php endif; ?>
                </div>
              <?php endwhile; ?>
            <?php else: ?>
              <div class="item-nota empty-note">
                <p>Todavia no hay notas o audios registrados.</p>
              </div>
            <?php endif; ?>
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
