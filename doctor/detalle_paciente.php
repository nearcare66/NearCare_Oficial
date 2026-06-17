<?php
session_start();
include("conexion.php");

if(!isset($_SESSION['id_doctor'])){
    header("Location: login.html");
    exit();
}

$id_doctor = $_SESSION['id_doctor'];

if(!isset($_GET['id'])){
    header("Location: pacientes.php");
    exit();
}

$id_paciente = $_GET['id'];

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
</head>
<body>

<nav class="navbar detalle-navbar">
    <div class="left-navbar">
        <a href="pacientes.php" class="back-arrow">‹</a>

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