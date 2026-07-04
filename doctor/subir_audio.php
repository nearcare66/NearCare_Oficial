<?php

session_start();
include("conexion.php");

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
    VALUES
    (
        ?,
        ?,
        'audio',
        ?
    )";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "iis",
        $id_paciente,
        $id_doctor,
        $ruta
    );

    $stmt->execute();
    $stmt->close();

    echo "OK";

}else{

    echo "ERROR";
}