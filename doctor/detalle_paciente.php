<?php
session_start();
include("conexion.php");

if(!isset($_SESSION['id_doctor'])){
    header("Location: login-form.php");
    exit();
}

$id_doctor = $_SESSION['id_doctor'];

if(!isset($_GET['id'])){
    header("Location: pacientes.php");
    exit();
}

$id_paciente = $_GET['id'];

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

//CREAR EVENTO
if(isset($_POST['crear_evento'])){
    $titulo = $_POST['titulo_evento'];
    $descripcion = $_POST['descripcion_evento'];
    $fecha = $_POST['fecha_evento'];

    $sqlEvento = "INSERT INTO eventos (id_paciente, titulo, descripcion, fecha)
                  VALUES (?, ?, ?, ?)";

    $stmtEvento = $conn->prepare($sqlEvento);
    $stmtEvento->bind_param("isss", $id_paciente, $titulo, $descripcion, $fecha);
    $stmtEvento->execute();
}
// ✅ OBTENER EVENTOS
$sqlEventos = "SELECT * FROM eventos WHERE id_paciente = $id_paciente ORDER BY fecha ASC";
$resultEventos = $conn->query($sqlEventos);

/* ELIMINAR */
if(isset($_GET['eliminar'])){
    $sql = "DELETE FROM pacientes WHERE id_paciente = ? AND id_doctor = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_paciente, $id_doctor);
    $stmt->execute();

    header("Location: pacientes.php");
    exit();
}

/* EDITAR */
if($_SERVER["REQUEST_METHOD"] == "POST"){

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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informacion del paciente</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/detalle_paciente.css?v=1">
    <link rel="stylesheet" href="../Css/botones-globales.css?v=2">
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
                <span>Bienvenido</span>
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
                <input id="condicion_paciente" type="text" name="condicion_paciente" value="<?php echo htmlspecialchars($paciente['condicion_paciente']); ?>" required>
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
        <article class="detalle-call-card">
            <button type="submit" class="btn-guardar-cambios">Guardar cambios</button>
            <div class="call-time">9:30-10:30 AM</div>

        <article class="detalle-schedule-card">
            <div class="schedule-box">
                <div>9:30-10:30 AM</div>
                <div>10:30-11:30 AM</div>
            </div>
        </article>
    </form>
</main>

<script>
document.getElementById('editar').addEventListener('submit', function () {
    const day = document.getElementById('fecha_dia').value.padStart(2, '0');
    const month = document.getElementById('fecha_mes').value.padStart(2, '0');
    const year = document.getElementById('fecha_anio').value;
    document.getElementById('fecha_ingreso').value = `${year}-${month}-${day}`;
});
</script>

</body>
</html>
