<?php
session_start();
require_once __DIR__ . '/../php/saludo.php';
include("conexion.php");
$conn->set_charset("utf8mb4");
$saludo = nearcare_saludo($_SESSION['nombre'] ?? '');

if(!isset($_SESSION['id_doctor'])){
    header("Location: login-form.php");
    exit();
}

$id_doctor = $_SESSION['id_doctor'];

if(!isset($_GET['id'])){
    header("Location: pacientes.php");
    exit();
}

$id_paciente = (int)$_GET['id'];

$sqlNotificaciones = "CREATE TABLE IF NOT EXISTS actualizaciones_pacientes (
    id_actualizacion INT AUTO_INCREMENT PRIMARY KEY,
    id_paciente INT NOT NULL,
    id_doctor INT NOT NULL,
    paciente_nombre VARCHAR(150) NOT NULL,
    doctor_nombre VARCHAR(100) NOT NULL,
    condicion_anterior VARCHAR(100) DEFAULT NULL,
    condicion_nueva VARCHAR(100) DEFAULT NULL,
    mensaje TEXT NOT NULL,
    creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
$conn->query($sqlNotificaciones);

function registrarActualizacionPaciente($conn, $id_paciente, $id_doctor, $mensaje) {
    $sqlPaciente = "SELECT p.nombre_completo, p.condicion_paciente, d.nombre AS doctor_nombre
                    FROM pacientes p
                    INNER JOIN doctores d ON d.id_doctor = p.id_doctor
                    WHERE p.id_paciente = ? AND p.id_doctor = ?
                    LIMIT 1";
    $stmtPaciente = $conn->prepare($sqlPaciente);
    $stmtPaciente->bind_param("ii", $id_paciente, $id_doctor);
    $stmtPaciente->execute();
    $paciente = $stmtPaciente->get_result()->fetch_assoc();
    $stmtPaciente->close();

    if (!$paciente) {
        return;
    }

    $pacienteNombre = $paciente['nombre_completo'];
    $doctorNombre = $paciente['doctor_nombre'] ?: 'Doctor';
    $condicion = $paciente['condicion_paciente'];

    $sqlInsertNotificacion = "INSERT INTO actualizaciones_pacientes
        (id_paciente, id_doctor, paciente_nombre, doctor_nombre, condicion_anterior, condicion_nueva, mensaje)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmtNotificacion = $conn->prepare($sqlInsertNotificacion);
    $stmtNotificacion->bind_param(
        "iisssss",
        $id_paciente,
        $id_doctor,
        $pacienteNombre,
        $doctorNombre,
        $condicion,
        $condicion,
        $mensaje
    );
    $stmtNotificacion->execute();
    $stmtNotificacion->close();
}

//CREAR EVENTO
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['crear_evento'])){
    $titulo = trim($_POST['titulo_evento'] ?? '');
    $descripcion = trim($_POST['descripcion_evento'] ?? '');
    $fecha = trim($_POST['fecha_evento'] ?? '');

    if($titulo !== '' && $fecha !== ''){
        $sqlEvento = "INSERT INTO eventos (id_paciente, titulo, descripcion, fecha)
                      VALUES (?, ?, ?, ?)";

        $stmtEvento = $conn->prepare($sqlEvento);
        $stmtEvento->bind_param("isss", $id_paciente, $titulo, $descripcion, $fecha);
        $stmtEvento->execute();
        $stmtEvento->close();
    }

    header("Location: detalle_paciente.php?id=".$id_paciente);
    exit();
}
// ✅ OBTENER EVENTOS
$sqlEventos = "SELECT * FROM eventos WHERE id_paciente = ? ORDER BY fecha ASC";
$stmtEventos = $conn->prepare($sqlEventos);
$stmtEventos->bind_param("i", $id_paciente);
$stmtEventos->execute();
$resultEventos = $stmtEventos->get_result();

/* ELIMINAR */
if(isset($_GET['eliminar'])){
    $sql = "DELETE FROM pacientes WHERE id_paciente = ? AND id_doctor = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_paciente, $id_doctor);
    $stmt->execute();

    header("Location: pacientes.php");
    exit();
}
if(
    $_SERVER["REQUEST_METHOD"] == "POST"
    && isset($_POST['guardar_nota'])
)
{
    $nota = trim($_POST['nota_texto'] ?? '');

    if($nota != ''){

        $sql = "INSERT INTO notas_paciente
        (
            id_paciente,
            id_doctor,
            tipo,
            nota
        )
        SELECT
            ?,
            ?,
            'texto',
            ?
        FROM pacientes
        WHERE id_paciente = ? AND id_doctor = ?
        LIMIT 1";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "iisii",
            $id_paciente,
            $id_doctor,
            $nota,
            $id_paciente,
            $id_doctor
        );

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            registrarActualizacionPaciente(
                $conn,
                $id_paciente,
                $id_doctor,
                "Doctor agrego una nueva nota medica para el paciente."
            );
        }
        $stmt->close();
    }

    header("Location: detalle_paciente.php?id=".$id_paciente);
    exit();
}

if(
    $_SERVER["REQUEST_METHOD"] == "POST"
    && isset($_POST['eliminar_audio'])
){
    $id_nota = (int)($_POST['eliminar_audio'] ?? 0);

    if($id_nota > 0){
        $sqlAudio = "SELECT archivo_audio
                     FROM notas_paciente
                     WHERE id_nota = ?
                       AND id_paciente = ?
                       AND id_doctor = ?
                       AND tipo = 'audio'
                     LIMIT 1";
        $stmtAudio = $conn->prepare($sqlAudio);
        $stmtAudio->bind_param("iii", $id_nota, $id_paciente, $id_doctor);
        $stmtAudio->execute();
        $audioNota = $stmtAudio->get_result()->fetch_assoc();
        $stmtAudio->close();

        if($audioNota){
            $sqlDeleteAudio = "DELETE FROM notas_paciente
                               WHERE id_nota = ?
                                 AND id_paciente = ?
                                 AND id_doctor = ?
                                 AND tipo = 'audio'";
            $stmtDeleteAudio = $conn->prepare($sqlDeleteAudio);
            $stmtDeleteAudio->bind_param("iii", $id_nota, $id_paciente, $id_doctor);
            $stmtDeleteAudio->execute();
            $audioEliminado = $stmtDeleteAudio->affected_rows > 0;
            $stmtDeleteAudio->close();

            if($audioEliminado && !empty($audioNota['archivo_audio'])){
                $rutaAudio = __DIR__ . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $audioNota['archivo_audio']);
                $baseAudios = realpath(__DIR__ . DIRECTORY_SEPARATOR . 'audios');
                $archivoReal = realpath($rutaAudio);

                if($baseAudios && $archivoReal && strpos($archivoReal, $baseAudios) === 0 && is_file($archivoReal)){
                    @unlink($archivoReal);
                }
            }

            if($audioEliminado){
                registrarActualizacionPaciente(
                    $conn,
                    $id_paciente,
                    $id_doctor,
                    "Doctor elimino un audio medico del paciente."
                );
            }
        }
    }

    header("Location: detalle_paciente.php?id=".$id_paciente);
    exit();
}

if(
    $_SERVER["REQUEST_METHOD"] == "POST"
    && isset($_POST['eliminar_nota'])
){
    $id_nota = (int)($_POST['eliminar_nota'] ?? 0);

    if($id_nota > 0){
        $sqlDeleteNota = "DELETE FROM notas_paciente
                          WHERE id_nota = ?
                            AND id_paciente = ?
                            AND id_doctor = ?
                            AND tipo = 'texto'";
        $stmtDeleteNota = $conn->prepare($sqlDeleteNota);
        $stmtDeleteNota->bind_param("iii", $id_nota, $id_paciente, $id_doctor);
        $stmtDeleteNota->execute();
        $notaEliminada = $stmtDeleteNota->affected_rows > 0;
        $stmtDeleteNota->close();

        if($notaEliminada){
            registrarActualizacionPaciente(
                $conn,
                $id_paciente,
                $id_doctor,
                "Doctor elimino una nota medica del paciente."
            );
        }
    }

    header("Location: detalle_paciente.php?id=".$id_paciente);
    exit();
}

if(
    $_SERVER["REQUEST_METHOD"] == "POST"
    && isset($_POST['guardar_edicion_nota'])
){
    $id_nota = (int)($_POST['guardar_edicion_nota'] ?? 0);
    $notasEditadas = $_POST['nota_editada'] ?? [];
    $notaEditada = trim($notasEditadas[$id_nota] ?? '');

    if($id_nota > 0 && $notaEditada !== ''){
        $sqlEditarNota = "UPDATE notas_paciente
                          SET nota = ?
                          WHERE id_nota = ?
                            AND id_paciente = ?
                            AND id_doctor = ?
                            AND tipo = 'texto'";
        $stmtEditarNota = $conn->prepare($sqlEditarNota);
        $stmtEditarNota->bind_param("siii", $notaEditada, $id_nota, $id_paciente, $id_doctor);
        $stmtEditarNota->execute();
        $notaEditadaOk = $stmtEditarNota->affected_rows > 0;
        $stmtEditarNota->close();

        if($notaEditadaOk){
            registrarActualizacionPaciente(
                $conn,
                $id_paciente,
                $id_doctor,
                "Doctor actualizo una nota medica del paciente."
            );
        }
    }

    header("Location: detalle_paciente.php?id=".$id_paciente);
    exit();
}

/* EDITAR */
if(
    $_SERVER["REQUEST_METHOD"] == "POST"
    && !isset($_POST['guardar_nota'])
    && !isset($_POST['eliminar_audio'])
    && !isset($_POST['eliminar_nota'])
    && !isset($_POST['guardar_edicion_nota'])
    && !isset($_POST['crear_evento'])
){

    $sqlAnterior = "SELECT p.*, d.nombre AS doctor_nombre
                    FROM pacientes p
                    INNER JOIN doctores d ON d.id_doctor = p.id_doctor
                    WHERE p.id_paciente = ? AND p.id_doctor = ?
                    LIMIT 1";
    $stmtAnterior = $conn->prepare($sqlAnterior);
    $stmtAnterior->bind_param("ii", $id_paciente, $id_doctor);
    $stmtAnterior->execute();
    $pacienteAnterior = $stmtAnterior->get_result()->fetch_assoc();
    $stmtAnterior->close();

    $nombre_completo = $_POST['nombre_completo'];
    $nc = $_POST['nc'];
    $edad = $_POST['edad'];
    $genero = $_POST['genero'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $motivo_ingreso = $_POST['motivo_ingreso'];
    $condicion_paciente = $_POST['condicion_paciente'];
    $diagnostico_medico = $_POST['diagnostico_medico'];

    $sql = "UPDATE pacientes SET
            nombre_completo = ?,
            nc = ?,
            edad = ?,
            genero = ?,
            fecha_ingreso = ?,
            motivo_ingreso = ?,
            condicion_paciente = ?,
            diagnostico_medico = ?
            WHERE id_paciente = ? AND id_doctor = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssisssssii",
        $nombre_completo,
        $nc,
        $edad,
        $genero,
        $fecha_ingreso,
        $motivo_ingreso,
        $condicion_paciente,
        $diagnostico_medico,
        $id_paciente,
        $id_doctor
    );

    $stmt->execute();

    if($pacienteAnterior){
        $condicionAnterior = trim((string)$pacienteAnterior['condicion_paciente']);
        $condicionNueva = trim((string)$condicion_paciente);
        $doctorNombre = $pacienteAnterior['doctor_nombre'] ?: ($_SESSION['nombre'] ?? 'Doctor');
        $pacienteNombre = $pacienteAnterior['nombre_completo'];

        $camposEditables = [
            'nombre_completo' => $nombre_completo,
            'nc' => $nc,
            'edad' => $edad,
            'genero' => $genero,
            'fecha_ingreso' => $fecha_ingreso,
            'motivo_ingreso' => $motivo_ingreso,
            'condicion_paciente' => $condicion_paciente,
            'diagnostico_medico' => $diagnostico_medico
        ];

        $huboCambios = false;
        foreach($camposEditables as $campo => $valorNuevo){
            if(trim((string)$pacienteAnterior[$campo]) !== trim((string)$valorNuevo)){
                $huboCambios = true;
                break;
            }
        }

        if($huboCambios){
            if(strcasecmp($condicionAnterior, $condicionNueva) !== 0){
                $mensaje = "Doctor " . $doctorNombre . " actualizo a " . $pacienteNombre . " de " . $condicionAnterior . " a " . $condicionNueva . ".";
            }else{
                $mensaje = "Doctor " . $doctorNombre . " actualizo la informacion de " . $pacienteNombre . ".";
            }

            $sqlInsertNotificacion = "INSERT INTO actualizaciones_pacientes
                (id_paciente, id_doctor, paciente_nombre, doctor_nombre, condicion_anterior, condicion_nueva, mensaje)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmtNotificacion = $conn->prepare($sqlInsertNotificacion);
            $stmtNotificacion->bind_param(
                "iisssss",
                $id_paciente,
                $id_doctor,
                $pacienteNombre,
                $doctorNombre,
                $condicionAnterior,
                $condicionNueva,
                $mensaje
            );
            $stmtNotificacion->execute();
            $stmtNotificacion->close();
        }
    }

    header("Location: detalle_paciente.php?id=".$id_paciente);
    exit();
}

/* OBTENER PACIENTE */
$sql = "SELECT p.*, d.nombre AS doctor_nombre
        FROM pacientes p
        INNER JOIN doctores d ON d.id_doctor = p.id_doctor
        WHERE p.id_paciente = ? AND p.id_doctor = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_paciente, $id_doctor);
$stmt->execute();
$resultado = $stmt->get_result();

if($resultado->num_rows == 0){
    header("Location: pacientes.php");
    exit();
}

$paciente = $resultado->fetch_assoc();
$fechaIngreso = $paciente['fecha_ingreso'] ? strtotime($paciente['fecha_ingreso']) : false;
$diaIngreso = $fechaIngreso ? date('j', $fechaIngreso) : '';
$mesIngreso = $fechaIngreso ? date('n', $fechaIngreso) : '';
$anioIngreso = $fechaIngreso ? date('Y', $fechaIngreso) : '';

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
$sqlNotas = "
SELECT *
FROM notas_paciente
WHERE id_paciente = ? AND id_doctor = ?
ORDER BY fecha_creacion DESC
";

$stmtNotas = $conn->prepare($sqlNotas);
$stmtNotas->bind_param("ii", $id_paciente, $id_doctor);
$stmtNotas->execute();

$resultNotas = $stmtNotas->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informacion del paciente</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/detalle_paciente.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../Css/botones-globales.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../Css/dark-mode.css?v=<?php echo time(); ?>">
  <script src="../dark-mode.js" defer></script>
    <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon_io%20%283%29/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon_io%20%283%29/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon_io%20%283%29/favicon-16x16.png">
    <link rel="shortcut icon" href="../img/favicon_io%20%283%29/favicon.ico">
    <link rel="manifest" href="../img/favicon_io%20%283%29/site.webmanifest">
</head>
<body class="doctor-detail-page">

<main class="detalle-page">
    <nav class="navbar detalle-navbar">
        <div class="left-navbar">
            <a href="pacientes.php" class="back-arrow" aria-label="Regresar">&#8249;</a>

            <div class="logo">
                <img src="../img/Designer (16).png" alt="NearCare">
            </div>
        </div>

        <h1 class="detalle-title">Informacion del paciente</h1>

        <div class="profile">
            <div class="welcome-box">
                <span><?php echo $saludo; ?></span>
                <div class="toggle" aria-hidden="true"></div>
            </div>
        </div>
    </nav>

    <form method="POST" id="editar" class="detalle-content">
        <article class="detalle-patient-card">
            <img src="../img/<?php echo htmlspecialchars($paciente['foto']); ?>" alt="Paciente">

            <label class="sr-only" for="nombre_completo">Nombre completo</label>
            <textarea id="nombre_completo" name="nombre_completo" class="patient-name-input" rows="2" required><?php echo htmlspecialchars($paciente['nombre_completo']); ?></textarea>

            <label class="sr-only" for="nc">Nc</label>
            <div class="nc-pill">
                <span>Nc</span>
                <input id="nc" type="text" name="nc" value="<?php echo htmlspecialchars($paciente['nc']); ?>" required>
            </div>

            <div class="doctor-name"><?php echo htmlspecialchars($paciente['doctor_nombre']); ?></div>
        </article>

        <aside class="detalle-side-info">
            <div class="editable-field">
                <label for="condicion_paciente">Condicion del paciente</label>
                <input id="condicion_paciente" class="condition-status <?php echo conditionStatusClass($paciente['condicion_paciente']); ?>" type="text" name="condicion_paciente" value="<?php echo htmlspecialchars($paciente['condicion_paciente']); ?>" required>
            </div>

            <div class="editable-field">
                <label for="genero">Genero</label>
                <input id="genero" type="text" name="genero" value="<?php echo htmlspecialchars($paciente['genero']); ?>" required>
            </div>

            <input type="hidden" name="edad" value="<?php echo htmlspecialchars($paciente['edad']); ?>">
        </aside>
        <div class="detalle-lower-row">
            <article class="detalle-date-card">
                <div class="section-label">Fecha de ingreso:</div>
                <input type="hidden" name="fecha_ingreso" id="fecha_ingreso" value="<?php echo htmlspecialchars($paciente['fecha_ingreso']); ?>">
                <div class="date-fields">
                    <input type="number" id="fecha_dia" value="<?php echo htmlspecialchars($diaIngreso); ?>" min="1" max="31" aria-label="Dia de ingreso" required>
                    <span>/</span>
                    <input type="number" id="fecha_mes" value="<?php echo htmlspecialchars($mesIngreso); ?>" min="1" max="12" aria-label="Mes de ingreso" required>
                    <span>/</span>
                    <input type="number" id="fecha_anio" value="<?php echo htmlspecialchars($anioIngreso); ?>" min="1900" max="2100" aria-label="Anio de ingreso" required>
                </div>
            </article>

            <article class="detalle-reason-card">
                <label for="motivo_ingreso" class="section-label">Motivo de ingreso:</label>
                <input id="motivo_ingreso" type="text" name="motivo_ingreso" value="<?php echo htmlspecialchars($paciente['motivo_ingreso']); ?>" required>
            </article>
        </div>

        <article class="detalle-diagnosis-card">
            <label for="diagnostico_medico" class="section-label">diagnostico:</label>
            <textarea id="diagnostico_medico" name="diagnostico_medico" required><?php echo htmlspecialchars($paciente['diagnostico_medico']); ?></textarea>
        </article>

        <article class="detalle-eventos-card">
            <h3>Agregar Evento</h3>

            <input type="text" name="titulo_evento" placeholder="Titulo">
            <input type="date" name="fecha_evento">
            <textarea name="descripcion_evento"></textarea>

            <button type="submit" name="crear_evento">Guardar Evento</button>
        </article>

        <article class="lista-eventos-doctor">
            <h3>Eventos del paciente</h3>

            <?php while($ev = $resultEventos->fetch_assoc()): ?>
                <div class="item-evento">
                    <strong><?php echo date('d/m/Y', strtotime($ev['fecha'])); ?></strong><br>
                    <?php echo htmlspecialchars($ev['titulo']); ?><br>
                    <small><?php echo htmlspecialchars($ev['descripcion']); ?></small>
                </div>
            <?php endwhile; ?>
        </article>

        <article class="notas-paciente-card">
            <h3>Notas Medicas</h3>

            <h4 class="notas-subtitle">Nota escrita</h4>
            <textarea name="nota_texto" placeholder="Agregar observacion medica..."></textarea>

            <button type="submit" name="guardar_nota" class="btn-guardar-audio btn-guardar-nota">
                Guardar Nota
            </button>

            <h4 class="notas-subtitle">Audio medico</h4>
            <div class="audio-controls">
                <button type="button" id="btnGrabar">Grabar Audio</button>
                <button type="button" id="btnDetener">Detener</button>
                <button type="button" id="btnGuardarAudio" class="btn-guardar-audio btn-audio-save">Guardar Audio</button>
            </div>

            <div id="audioTimer" class="audio-timer" aria-live="polite">
                <span class="timer-dot" aria-hidden="true"></span>
                <span id="audioTimerText">Listo para grabar</span>
            </div>

            <audio id="audioPreview" controls></audio>
        </article>

        <div class="historial-notas">
            <h3>Historial</h3>
            <h4 class="notas-subtitle">Opciones del historial</h4>

            <?php while($nota = $resultNotas->fetch_assoc()): ?>
                <div class="item-nota">
                    <small>
                        <?= date("d/m/Y H:i", strtotime($nota['fecha_creacion'])); ?>
                    </small>

                    <?php if($nota['tipo'] == 'texto'): ?>
                        <textarea class="nota-edit-textarea" name="nota_editada[<?= (int)$nota['id_nota']; ?>]" rows="3"><?= htmlspecialchars($nota['nota'], ENT_QUOTES, 'UTF-8') ?></textarea>

                        <div class="nota-actions">
                            <button
                                type="submit"
                                name="guardar_edicion_nota"
                                value="<?= (int)$nota['id_nota']; ?>"
                                class="btn-editar-nota"
                                formnovalidate>
                                Guardar edicion
                            </button>

                            <button
                                type="submit"
                                name="eliminar_nota"
                                value="<?= (int)$nota['id_nota']; ?>"
                                class="btn-eliminar-nota"
                                formnovalidate
                                onclick="return confirm('Desea eliminar esta nota?');">
                                Eliminar nota
                            </button>
                        </div>
                    <?php else: ?>
                        <audio controls preload="metadata">
                            <source src="audio_nota.php?id=<?= (int)$nota['id_nota']; ?>" type="audio/webm">
                            Tu navegador no soporta audio.
                        </audio>

                        <div class="nota-actions">
                            <label class="audio-speed-control">
                                <span>Velocidad</span>
                                <select class="audio-speed">
                                    <option value="0.75">0.75x</option>
                                    <option value="1" selected>1x</option>
                                    <option value="1.25">1.25x</option>
                                    <option value="1.5">1.5x</option>
                                    <option value="2">2x</option>
                                </select>
                            </label>

                            <a href="audio_nota.php?id=<?= (int)$nota['id_nota']; ?>" target="_blank" rel="noopener">
                                Abrir audio
                            </a>

                            <button
                                type="submit"
                                name="eliminar_audio"
                                value="<?= (int)$nota['id_nota']; ?>"
                                class="btn-eliminar-audio"
                                formnovalidate
                                onclick="return confirm('Desea eliminar este audio?');">
                                Eliminar audio
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>

        <article class="detalle-call-card">
            <button type="submit" class="btn-guardar-cambios">Guardar cambios</button>
        </article>
    </form>
</main>

<script>
function conditionStatusClass(condition) {
    const normalized = condition
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .trim();

    if (normalized.includes('grave') || normalized.includes('critico')) {
        return 'condition-danger';
    }

    if (normalized.includes('estable')) {
        return 'condition-stable';
    }

    if (normalized.includes('observacion') || normalized.includes('delicado') || normalized.includes('regular')) {
        return 'condition-warning';
    }

    return '';
}

const condicionPaciente = document.getElementById('condicion_paciente');
condicionPaciente.addEventListener('input', function () {
    this.classList.remove('condition-stable', 'condition-warning', 'condition-danger');
    const statusClass = conditionStatusClass(this.value);

    if (statusClass) {
        this.classList.add(statusClass);
    }
});

document.getElementById('editar').addEventListener('submit', function () {
    const day = document.getElementById('fecha_dia').value.padStart(2, '0');
    const month = document.getElementById('fecha_mes').value.padStart(2, '0');
    const year = document.getElementById('fecha_anio').value;
    document.getElementById('fecha_ingreso').value = `${year}-${month}-${day}`;
});
</script>
<script>

let mediaRecorder;
let audioChunks = [];
let audioBlob = null;
let recordingTimer = null;
let recordingSeconds = 0;
let currentStream = null;

const btnGrabar = document.getElementById('btnGrabar');
const btnDetener = document.getElementById('btnDetener');
const btnGuardarAudio = document.getElementById('btnGuardarAudio');
const audioPreview = document.getElementById('audioPreview');
const audioTimer = document.getElementById('audioTimer');
const audioTimerText = document.getElementById('audioTimerText');

function formatRecordingTime(seconds){
    const minutes = String(Math.floor(seconds / 60)).padStart(2, '0');
    const remainingSeconds = String(seconds % 60).padStart(2, '0');
    return `${minutes}:${remainingSeconds}`;
}

function startRecordingTimer(){
    recordingSeconds = 0;
    audioTimerText.textContent = "Grabando 00:00";
    audioTimer.classList.add('recording');
    btnGrabar.disabled = true;
    btnDetener.disabled = false;
    btnGuardarAudio.disabled = true;

    clearInterval(recordingTimer);
    recordingTimer = setInterval(function(){
        recordingSeconds++;
        audioTimerText.textContent = `Grabando ${formatRecordingTime(recordingSeconds)}`;
    }, 1000);
}

function stopRecordingTimer(){
    clearInterval(recordingTimer);
    recordingTimer = null;
    audioTimer.classList.remove('recording');
    audioTimerText.textContent = `Duracion ${formatRecordingTime(recordingSeconds)}`;
    btnGrabar.disabled = false;
    btnDetener.disabled = true;
    btnGuardarAudio.disabled = false;
}

btnDetener.disabled = true;
btnGuardarAudio.disabled = true;

btnGrabar.onclick = async function(){

    const stream = await navigator.mediaDevices.getUserMedia({
        audio: true
    });
    currentStream = stream;

    audioChunks = [];
    audioBlob = null;
    audioPreview.removeAttribute('src');
    audioPreview.load();

    mediaRecorder = new MediaRecorder(stream);

    mediaRecorder.ondataavailable = function(event){
            if(event.data.size > 0){
                audioChunks.push(event.data);
            }
        };

    mediaRecorder.onstop = function(){

        if(audioChunks.length === 0){
            alert("No se grabo audio");
            if(currentStream){
                currentStream.getTracks().forEach(track => track.stop());
                currentStream = null;
            }
            stopRecordingTimer();
            btnGuardarAudio.disabled = true;
            return;
        }

        audioBlob = new Blob(
            audioChunks,
            {
                type:"audio/webm"
            }
        );

        audioPreview.src =
            URL.createObjectURL(audioBlob);

        audioPreview.load();
        if(currentStream){
            currentStream.getTracks().forEach(track => track.stop());
            currentStream = null;
        }
        stopRecordingTimer();
    };

    mediaRecorder.start(1000);
    startRecordingTimer();
};

btnDetener.onclick = function(){

    if(mediaRecorder &&
        mediaRecorder.state !== 'inactive'){

        mediaRecorder.stop();
    }
};

btnGuardarAudio.onclick = function(){

    if(!audioBlob){
        alert("Primero grabe un audio");
        return;
    }

    btnGuardarAudio.disabled = true;

    const formData = new FormData();

    formData.append(
        "audio",
        audioBlob,
        "audio.webm"
    );

    formData.append(
        "id_paciente",
        <?= $id_paciente ?>
    );

    fetch("subir_audio.php",{
        method:"POST",
        body:formData
    })
    .then(res => res.text())
    .then(data => {

        console.log(data);

        if(data.trim() === "OK"){
            alert("Audio guardado");
            location.reload();
        }else{
            alert(data);
            btnGuardarAudio.disabled = false;
        }
    })
    .catch(() => {
        alert("No se pudo guardar el audio");
        btnGuardarAudio.disabled = false;
    });
};

document.querySelectorAll('.audio-speed').forEach(function(select){
    select.addEventListener('change', function(){
        const item = this.closest('.item-nota');
        const audio = item ? item.querySelector('audio') : null;

        if(audio){
            audio.playbackRate = Number(this.value);
        }
    });
});

</script>
</body>
</html>

