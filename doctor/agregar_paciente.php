<?php
session_start();
include("conexion.php");

if(!isset($_SESSION['id_doctor'])){
    header("Location: login-form.php");
    exit();
}

$id_doctor = $_SESSION['id_doctor'];

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nombre_completo = $_POST['nombre_completo'];
    $nc = $_POST['nc'];
    $edad = $_POST['edad'];
    $genero = $_POST['genero'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $motivo_ingreso = $_POST['motivo_ingreso'];
    $condicion_paciente = $_POST['condicion_paciente'];
    $diagnostico_medico = $_POST['diagnostico_medico'];

    $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $foto = time() . "_" . rand(1000,9999) . "." . $extension;

    move_uploaded_file(
        $_FILES['foto']['tmp_name'],
        "../img/" . $foto
    );

    $sql = "INSERT INTO pacientes 
    (id_doctor, nombre_completo, nc, edad, genero, fecha_ingreso, motivo_ingreso, condicion_paciente, diagnostico_medico, foto)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ississssss",
        $id_doctor,
        $nombre_completo,
        $nc,
        $edad,
        $genero,
        $fecha_ingreso,
        $motivo_ingreso,
        $condicion_paciente,
        $diagnostico_medico,
        $foto
    );

    if($stmt->execute()){
        header("Location: pacientes.php");
        exit();
    }else{
        echo "Error al agregar paciente";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Paciente</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/agregar_paciente.css?v=3">
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

<nav class="navbar">
    <div class="left-navbar">
        <a href="pacientes.php" class="back-arrow">&#8249;</a>

        <div class="logo">
            <img src="../img/Designer (16).png" alt="NearCare">
        </div>
    </div>

    <h1 class="titulo-pacientes">Agregar Paciente</h1>
</nav>

<div class="agregar-container">

    <form action="agregar_paciente.php" method="POST" enctype="multipart/form-data" class="form-agregar">

        <div class="form-field field-full">
            <label>Nombre completo<span>*</span></label>
            <input type="text" name="nombre_completo" placeholder="Nombre completo" required>
        </div>

        <div class="form-field">
            <label>Nc<span>*</span></label>
            <input type="text" name="nc" placeholder="Nc" required>
        </div>

        <div class="form-field">
            <label>Edad<span>*</span></label>
            <input type="number" name="edad" placeholder="Edad" required>
        </div>

        <div class="form-field">
            <label>Genero<span>*</span></label>
            <select name="genero" required>
                <option value="">Genero</option>
                <option value="Femenino">Femenino</option>
                <option value="Masculino">Masculino</option>
            </select>
        </div>

        <div class="form-field">
            <label>Fecha de ingreso<span>*</span></label>
            <input type="date" name="fecha_ingreso" required>
        </div>

        <div class="form-field field-full">
            <label>Motivo de ingreso<span>*</span></label>
            <input type="text" name="motivo_ingreso" placeholder="Motivo de ingreso" required>
        </div>

        <div class="form-field field-full">
            <label>Condición del paciente<span>*</span></label>
            <input type="text" name="condicion_paciente" placeholder="Condicion del paciente" required>
        </div>

        <div class="form-field field-full">
            <label>Diagnostico medico</label>
            <textarea name="diagnostico_medico" placeholder="Diagnostico medico"></textarea>
        </div>

        <div class="form-field field-full">
            <label>Foto del paciente<span>*</span></label>
            <input type="file" name="foto" accept="image/*" required>
        </div>

        <button type="submit">Guardar paciente</button>

    </form>

</div>

</body>
</html>
