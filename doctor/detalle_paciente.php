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
$sql = "SELECT * FROM pacientes WHERE id_paciente = ? AND id_doctor = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_paciente, $id_doctor);
$stmt->execute();
$resultado = $stmt->get_result();

if($resultado->num_rows == 0){
    header("Location: pacientes.php");
    exit();
}

$paciente = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle Paciente</title>
    <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="../Css/botones-globales.css?v=2">
</head>
<body>

<nav class="navbar detalle-navbar">
    <div class="left-navbar">
        <a href="pacientes.php" class="back-arrow">&#8249;</a>

        <div class="logo">
            <img src="../img/Designer (16).png" alt="NearCare">
        </div>
    </div>

    <h1 class="detalle-title">
        <?php echo htmlspecialchars($paciente['nombre_completo']); ?>
    </h1>

    <div class="acciones">
        <a href="detalle_paciente.php?id=<?php echo $id_paciente; ?>">↻</a>
        <a href="#editar">✎</a>
        <a 
            href="detalle_paciente.php?id=<?php echo $id_paciente; ?>&eliminar=1"
            onclick="return confirm('¿Seguro que quieres eliminar este paciente?')"
        >🗑</a>
    </div>
</nav>

<div class="detalle-container">

    <div class="paciente-header">
        <img src="../img/<?php echo htmlspecialchars($paciente['foto']); ?>" alt="Paciente">

        <div>
            <h2><?php echo htmlspecialchars($paciente['nombre_completo']); ?></h2>
            <p>Nc<?php echo htmlspecialchars($paciente['nc']); ?></p>
        </div>
    </div>

    <form method="POST" id="editar">

        <div class="detalle-card">
            <label>Nombre completo:</label>
            <input type="text" name="nombre_completo" value="<?php echo htmlspecialchars($paciente['nombre_completo']); ?>">
        </div>

        <div class="detalle-card">
            <label>Nc:</label>
            <input type="text" name="nc" value="<?php echo htmlspecialchars($paciente['nc']); ?>">
        </div>

        <div class="detalle-card">
            <label>Edad:</label>
            <input type="number" name="edad" value="<?php echo htmlspecialchars($paciente['edad']); ?>">

            <label>Género:</label>
            <input type="text" name="genero" value="<?php echo htmlspecialchars($paciente['genero']); ?>">
        </div>

        <div class="detalle-card">
            <label>Fecha de ingreso:</label>
            <input type="date" name="fecha_ingreso" value="<?php echo htmlspecialchars($paciente['fecha_ingreso']); ?>">
        </div>

        <div class="detalle-card">
            <label>Motivo de ingreso:</label>
            <input type="text" name="motivo_ingreso" value="<?php echo htmlspecialchars($paciente['motivo_ingreso']); ?>">

            <label>Condición del paciente:</label>
            <input type="text" name="condicion_paciente" value="<?php echo htmlspecialchars($paciente['condicion_paciente']); ?>">
        </div>

        <div class="detalle-card">
            <label>Diagnóstico médico:</label>
            <textarea name="diagnostico_medico"><?php echo htmlspecialchars($paciente['diagnostico_medico']); ?></textarea>
        </div>

        <button type="submit" class="btn-guardar-cambios">Guardar cambios</button>

    </form>

</div>

</body>
</html>
