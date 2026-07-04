<?php
session_start();
include("conexion.php");

if(!isset($_SESSION['id_doctor'])){
    header("Location: login-form.php");
    exit();
}

$id_doctor = $_SESSION['id_doctor'];
$busqueda = "";

if(isset($_GET['buscar'])){
    $busqueda = $_GET['buscar'];
    $buscar_param = "%" . $busqueda . "%";

    $sql = "SELECT * FROM pacientes 
            WHERE id_doctor = ? 
            AND (nombre_completo LIKE ? OR nc LIKE ?)
            ORDER BY nombre_completo";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $id_doctor, $buscar_param, $buscar_param);
}else{
    $sql = "SELECT * FROM pacientes 
            WHERE id_doctor = ?
            ORDER BY nombre_completo";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_doctor);
}

$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pacientes</title>
    <link rel="stylesheet" href="css/style.css?v=5">
  <link rel="stylesheet" href="../Css/botones-globales.css?v=2">
</head>
<body class="doctor-patients-page">

<nav class="navbar">
    <div class="left-navbar">
        <a href="dashboard.php" class="back-arrow">&#8249;</a>

        <div class="logo">
            <img src="../img/Designer (16).png" alt="NearCare">
        </div>
    </div>

    <h1 class="titulo-pacientes">Pacientes</h1>

    <form class="search-box" method="GET" action="pacientes.php">
        <input 
            type="text" 
            name="buscar" 
            placeholder="Buscar"
            value="<?php echo htmlspecialchars($busqueda); ?>"
        >
        <button type="submit">🔍</button>
    </form>
</nav>

<a href="agregar_paciente.php" class="btn-agregar">+</a>

<div class="pacientes-container">

    <div class="linea-verde"></div>

    <?php while($paciente = $resultado->fetch_assoc()) { ?>

        <div class="card-paciente">

            <img 
                src="../img/<?php echo htmlspecialchars($paciente['foto']); ?>" 
                class="foto-paciente"
                alt="Paciente"
            >

            <div class="info-paciente">
                <h2><?php echo htmlspecialchars($paciente['nombre_completo']); ?></h2>
                <p>Nc<?php echo htmlspecialchars($paciente['nc']); ?></p>
            </div>

            <a 
                href="detalle_paciente.php?id=<?php echo $paciente['id_paciente']; ?>" 
                class="btn-ver"
            >
                ›
            </a>

        </div>

    <?php } ?>

</div>

</body>
</html>
