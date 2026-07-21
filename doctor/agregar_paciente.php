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
    $condiciones_permitidas = ['En observación', 'Grave', 'Estable'];
    $condicion_paciente = trim($_POST['condicion_paciente'] ?? '');

    if(!in_array($condicion_paciente, $condiciones_permitidas, true)){
        die("Condición del paciente no válida.");
    }
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
    <link rel="stylesheet" href="css/agregar_paciente.css?v=<?php echo time(); ?>">
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
            <label for="condicion_paciente">Condición del paciente<span>*</span></label>
            <select id="condicion_paciente" name="condicion_paciente" required>
                <option value="" selected disabled>Seleccione una condición</option>
                <option value="En observación">En observación</option>
                <option value="Grave">Grave</option>
                <option value="Estable">Estable</option>
            </select>
        </div>

        <div class="form-field field-full">
            <label>Diagnostico medico</label>
            <textarea name="diagnostico_medico" placeholder="Diagnostico medico"></textarea>
        </div>

        <div class="form-field field-full">
            <label for="foto">Foto del paciente<span>*</span></label>
            <div class="photo-picker">
                <input id="foto" class="photo-picker-input" type="file" name="foto" accept="image/*" required>
                <label class="photo-picker-button" for="foto">
                    <svg width="20" height="20" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M9 3 7.2 5H4a3 3 0 0 0-3 3v9a3 3 0 0 0 3 3h16a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3h-3.2L15 3H9Zm3 14.5A5.5 5.5 0 1 1 12 6a5.5 5.5 0 0 1 0 11.5Zm0-2.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                    </svg>
                    Seleccionar foto
                </label>
                <span id="photo-file-name" class="photo-picker-name">Ninguna foto seleccionada</span>
            </div>
        </div>

        <button type="submit">Guardar paciente</button>

    </form>

</div>

<script>
const photoInput = document.getElementById('foto');
const photoFileName = document.getElementById('photo-file-name');

photoInput.addEventListener('change', function () {
    photoFileName.textContent = this.files.length
        ? this.files[0].name
        : 'Ninguna foto seleccionada';
});
</script>

</body>
</html>
