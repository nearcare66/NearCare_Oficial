<?php
session_start();

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/conexion.php';

if (!isset($_SESSION['id_doctor'])) {
    header('Location: login-form.php');
    exit();
}

if (!isset($conn) || !($conn instanceof mysqli)) {
    die('Error: la conexión a la base de datos no está disponible. Revisa conexion.php.');
}

$id_doctor = (int) $_SESSION['id_doctor'];
$mensajeError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_completo = trim($_POST['nombre_completo'] ?? '');
    $nc = trim($_POST['nc'] ?? '');
    $edad = filter_input(INPUT_POST, 'edad', FILTER_VALIDATE_INT);
    $genero = trim($_POST['genero'] ?? '');
    $fecha_ingreso = trim($_POST['fecha_ingreso'] ?? '');
    $motivo_ingreso = trim($_POST['motivo_ingreso'] ?? '');
    $condicion_paciente = trim($_POST['condicion_paciente'] ?? '');
    $diagnostico_medico = trim($_POST['diagnostico_medico'] ?? '');

    $generosPermitidos = ['Femenino', 'Masculino'];
    $condicionesPermitidas = ['Grave', 'Estable', 'En observación'];

    if ($nombre_completo === '') {
        $mensajeError = 'Debe ingresar el nombre completo.';
    } elseif ($nc === '') {
        $mensajeError = 'Debe ingresar el NC ID.';
    } elseif ($edad === false || $edad < 1) {
        $mensajeError = 'Debe ingresar una edad válida.';
    } elseif (!in_array($genero, $generosPermitidos, true)) {
        $mensajeError = 'Debe seleccionar un sexo válido.';
    } elseif ($fecha_ingreso === '') {
        $mensajeError = 'Debe seleccionar la fecha de ingreso.';
    } elseif ($motivo_ingreso === '') {
        $mensajeError = 'Debe ingresar el motivo de ingreso.';
    } elseif (!in_array($condicion_paciente, $condicionesPermitidas, true)) {
        $mensajeError = 'Debe seleccionar una condición válida.';
    }

    $foto = '';
    $rutaDestino = '';

    if ($mensajeError === '') {
        if (
            !isset($_FILES['foto']) ||
            $_FILES['foto']['error'] !== UPLOAD_ERR_OK
        ) {
            $mensajeError = 'Debe seleccionar una foto válida.';
        }
    }

    if ($mensajeError === '') {
        $archivoTemporal = $_FILES['foto']['tmp_name'];
        $nombreOriginal = $_FILES['foto']['name'];
        $tamanoArchivo = (int) $_FILES['foto']['size'];

        if ($tamanoArchivo <= 0) {
            $mensajeError = 'La imagen seleccionada está vacía.';
        } elseif ($tamanoArchivo > 5 * 1024 * 1024) {
            $mensajeError = 'La imagen no debe superar los 5 MB.';
        }

        $extension = strtolower(
            pathinfo($nombreOriginal, PATHINFO_EXTENSION)
        );

        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];

        if (
            $mensajeError === '' &&
            !in_array($extension, $extensionesPermitidas, true)
        ) {
            $mensajeError = 'Solo se permiten imágenes JPG, JPEG, PNG o WEBP.';
        }

        if ($mensajeError === '') {
            $tiposMimePermitidos = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];

            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $tipoMime = $finfo->file($archivoTemporal);

            if (!in_array($tipoMime, $tiposMimePermitidos, true)) {
                $mensajeError = 'El archivo seleccionado no es una imagen válida.';
            }
        }

        if ($mensajeError === '') {
            $carpetaImagenes = __DIR__ . '/../img/';

            if (!is_dir($carpetaImagenes)) {
                if (!mkdir($carpetaImagenes, 0775, true)) {
                    $mensajeError = 'No se pudo crear la carpeta de imágenes.';
                }
            }

            if (
                $mensajeError === '' &&
                !is_writable($carpetaImagenes)
            ) {
                $mensajeError = 'La carpeta de imágenes no tiene permisos de escritura.';
            }

            if ($mensajeError === '') {
                try {
                    $nombreAleatorio = bin2hex(random_bytes(8));
                } catch (Exception $e) {
                    $nombreAleatorio = uniqid('', true);
                }

                $foto = time() . '_' . $nombreAleatorio . '.' . $extension;
                $rutaDestino = $carpetaImagenes . $foto;

                if (!move_uploaded_file($archivoTemporal, $rutaDestino)) {
                    $mensajeError = 'No se pudo guardar la foto del paciente.';
                }
            }
        }
    }

    if ($mensajeError === '') {
        $sql = "INSERT INTO pacientes (
                    id_doctor,
                    nombre_completo,
                    nc,
                    edad,
                    genero,
                    fecha_ingreso,
                    motivo_ingreso,
                    condicion_paciente,
                    diagnostico_medico,
                    foto
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            if ($rutaDestino !== '' && file_exists($rutaDestino)) {
                unlink($rutaDestino);
            }

            $mensajeError = 'Error al preparar la consulta: ' . $conn->error;
        } else {
            $stmt->bind_param(
                'ississssss',
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

            if ($stmt->execute()) {
                $stmt->close();

                header('Location: pacientes.php');
                exit();
            }

            if ($rutaDestino !== '' && file_exists($rutaDestino)) {
                unlink($rutaDestino);
            }

            $mensajeError = 'Error al agregar el paciente: ' . $stmt->error;
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Agregar paciente</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/agregar_paciente.css?v=3">

    <link
        rel="stylesheet"
        href="../Css/botones-globales.css?v=<?php echo time(); ?>"
    >

    <link
        rel="stylesheet"
        href="../Css/dark-mode.css?v=1"
    >

    <script src="../dark-mode.js" defer></script>

    <link
        rel="apple-touch-icon"
        sizes="180x180"
        href="../img/favicon_io%20%283%29/apple-touch-icon.png"
    >

    <link
        rel="icon"
        type="image/png"
        sizes="32x32"
        href="../img/favicon_io%20%283%29/favicon-32x32.png"
    >

    <link
        rel="icon"
        type="image/png"
        sizes="16x16"
        href="../img/favicon_io%20%283%29/favicon-16x16.png"
    >

    <link
        rel="shortcut icon"
        href="../img/favicon_io%20%283%29/favicon.ico"
    >

    <link
        rel="manifest"
        href="../img/favicon_io%20%283%29/site.webmanifest"
    >
</head>

<body>

<nav class="navbar">
    <div class="left-navbar">
        <a
            href="pacientes.php"
            class="back-arrow"
            aria-label="Volver a pacientes"
        >
            &#8249;
        </a>

        <div class="logo">
            <img
                src="../img/Designer (16).png"
                alt="NearCare"
            >
        </div>
    </div>

    <h1 class="titulo-pacientes">Agregar paciente</h1>
</nav>

<div class="agregar-container">

    <?php if ($mensajeError !== ''): ?>
        <div class="mensaje-error">
            <?php
            echo htmlspecialchars(
                $mensajeError,
                ENT_QUOTES,
                'UTF-8'
            );
            ?>
        </div>
    <?php endif; ?>

    <form
        action="agregar_paciente.php"
        method="POST"
        enctype="multipart/form-data"
        class="form-agregar"
    >

        <div class="form-field field-full">
            <label for="nombre_completo">
                Nombre completo<span>*</span>
            </label>

            <input
                type="text"
                id="nombre_completo"
                name="nombre_completo"
                placeholder="Nombre completo"
                value="<?php
                echo htmlspecialchars(
                    $_POST['nombre_completo'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                );
                ?>"
                required
            >
        </div>

        <div class="form-field">
            <label for="nc">
                NC ID<span>*</span>
            </label>

            <input
                type="text"
                id="nc"
                name="nc"
                placeholder="NC ID"
                value="<?php
                echo htmlspecialchars(
                    $_POST['nc'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                );
                ?>"
                required
            >
        </div>

        <div class="form-field">
            <label for="edad">
                Edad<span>*</span>
            </label>

            <input
                type="number"
                id="edad"
                name="edad"
                placeholder="Edad"
                min="1"
                max="130"
                value="<?php
                echo htmlspecialchars(
                    $_POST['edad'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                );
                ?>"
                required
            >
        </div>

        <div class="form-field">
            <label for="genero">
                Sexo<span>*</span>
            </label>

            <select id="genero" name="genero" required>
                <option value="">Seleccione el sexo</option>

                <option
                    value="Femenino"
                    <?php
                    echo (
                        ($_POST['genero'] ?? '') === 'Femenino'
                    ) ? 'selected' : '';
                    ?>
                >
                    Femenino
                </option>

                <option
                    value="Masculino"
                    <?php
                    echo (
                        ($_POST['genero'] ?? '') === 'Masculino'
                    ) ? 'selected' : '';
                    ?>
                >
                    Masculino
                </option>
            </select>
        </div>

        <div class="form-field">
            <label for="fecha_ingreso">
                Fecha de ingreso<span>*</span>
            </label>

            <input
                type="date"
                id="fecha_ingreso"
                name="fecha_ingreso"
                value="<?php
                echo htmlspecialchars(
                    $_POST['fecha_ingreso'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                );
                ?>"
                required
            >
        </div>

        <div class="form-field field-full">
            <label for="motivo_ingreso">
                Motivo de ingreso<span>*</span>
            </label>

            <input
                type="text"
                id="motivo_ingreso"
                name="motivo_ingreso"
                placeholder="Motivo de ingreso"
                value="<?php
                echo htmlspecialchars(
                    $_POST['motivo_ingreso'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                );
                ?>"
                required
            >
        </div>

        <div class="form-field field-full">
            <label for="condicion_paciente">
                Condición del paciente<span>*</span>
            </label>

            <select
                id="condicion_paciente"
                name="condicion_paciente"
                required
            >
                <option value="">
                    Seleccione una condición
                </option>

                <option
                    value="Grave"
                    <?php
                    echo (
                        ($_POST['condicion_paciente'] ?? '') === 'Grave'
                    ) ? 'selected' : '';
                    ?>
                >
                    Grave
                </option>

                <option
                    value="Estable"
                    <?php
                    echo (
                        ($_POST['condicion_paciente'] ?? '') === 'Estable'
                    ) ? 'selected' : '';
                    ?>
                >
                    Estable
                </option>

                <option
                    value="En observación"
                    <?php
                    echo (
                        ($_POST['condicion_paciente'] ?? '') ===
                        'En observación'
                    ) ? 'selected' : '';
                    ?>
                >
                    En observación
                </option>
            </select>
        </div>

        <div class="form-field field-full">
            <label for="diagnostico_medico">
                Diagnóstico médico
            </label>

            <textarea
                id="diagnostico_medico"
                name="diagnostico_medico"
                placeholder="Diagnóstico médico"
            ><?php
            echo htmlspecialchars(
                $_POST['diagnostico_medico'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            );
            ?></textarea>
        </div>

        <div class="form-field field-full">
            <label for="foto">
                Foto del paciente<span>*</span>
            </label>

            <input
                type="file"
                id="foto"
                name="foto"
                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                required
            >
        </div>

        <button type="submit">
            Guardar paciente
        </button>

    </form>

</div>

</body>
</html>