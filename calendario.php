<?php
include("conexion.php");

$id_paciente = 1; // puedes cambiar esto dinámicamente

$query = "SELECT * FROM eventos WHERE id_paciente = $id_paciente";
$result = mysqli_query($conn, $query);

$eventos = [];

while ($row = mysqli_fetch_assoc($result)) {
    $dia = date('j', strtotime($row['fecha']));
    $eventos[$dia][] = $row;
}
?>