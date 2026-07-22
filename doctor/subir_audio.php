<?php

session_start();
include("conexion.php");
$conn->set_charset("utf8mb4");

function registrarActualizacionPaciente($conn, $id_paciente, $id_doctor, $mensaje) {
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

    $sqlInsert = "INSERT INTO actualizaciones_pacientes
        (id_paciente, id_doctor, paciente_nombre, doctor_nombre, condicion_anterior, condicion_nueva, mensaje)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param(
        "iisssss",
        $id_paciente,
        $id_doctor,
        $pacienteNombre,
        $doctorNombre,
        $condicion,
        $condicion,
        $mensaje
    );
    $stmtInsert->execute();
    $stmtInsert->close();
}

if(!isset($_SESSION['id_doctor'])){
    exit("No autorizado");
}

if(
    !isset($_FILES['audio'])
    || !isset($_POST['id_paciente'])
){
    exit("Datos incompletos");
}

$id_doctor = $_SESSION['id_doctor'];
$id_paciente = (int)$_POST['id_paciente'];

$carpeta = "audios/";

if(!file_exists($carpeta)){
    mkdir($carpeta, 0777, true);
}

$nombreArchivo =
    time() . "_" . uniqid() . ".webm";

$ruta =
    $carpeta . $nombreArchivo;

if(
    move_uploaded_file(
        $_FILES['audio']['tmp_name'],
        $ruta
    )
){

    $sql = "INSERT INTO notas_paciente
    (
        id_paciente,
        id_doctor,
        tipo,
        archivo_audio
    )
    SELECT
        ?,
        ?,
        'audio',
        ?
    FROM pacientes
    WHERE id_paciente = ? AND id_doctor = ?
    LIMIT 1";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "iisii",
        $id_paciente,
        $id_doctor,
        $ruta,
        $id_paciente,
        $id_doctor
    );

    $stmt->execute();
    $audioGuardado = $stmt->affected_rows > 0;

    if ($audioGuardado) {
        registrarActualizacionPaciente(
            $conn,
            $id_paciente,
            $id_doctor,
            "El doctor agregó un nuevo audio médico para el paciente."
        );
    }
    $stmt->close();

    if ($audioGuardado) {
        echo "OK";
    } else {
        @unlink($ruta);
        echo "No autorizado para este paciente";
    }

}else{

    echo "ERROR";
}
