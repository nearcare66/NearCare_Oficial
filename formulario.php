<?php
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="Css/style7.css">
</head>
<body>

<div class="contenedor">

   
    <nav class="navbar">
        <div class="nav-left">
            <img src="img/Designer (16).png" alt="Logo NearCare" class="logo">
        </div>

        <div class="nav-right">
            <img src="img/avatar.png" alt="Usuario" class="avatar">
            <div class="bienvenido">
                <span>Bienvenido</span>
            </div>
        </div>
    </nav>

    <div class="titulo">
        Registrar paciente
    </div>

    <form class="formulario" method="POST">

    <label>ID de paciente</label>
    <input type="text" name="id_paciente" placeholder="Ingrese el ID">

    <label>Nombre completo del paciente</label>
    <input type="text" name="nombre" placeholder="Ingrese el nombre completo">

    <label>Edad actual</label>
    <input type="text" name="edad" placeholder="Ingrese la edad">

    <label>Género</label>
    <input type="text" name="genero" placeholder="Ingrese el género">

    <label>Condición del paciente</label>
    <input type="text" name="condicion" placeholder="Ingrese la condición">

    <label>Médico responsable</label>
    <input type="text" name="medico" placeholder="Ingrese el médico responsable">

    <label>Hora de atención</label>
    <input type="text" name="hora" placeholder="Ingrese la hora">

    <label>Horario de visitas</label>
    <input type="text" name="horario" placeholder="Ingrese el horario de visitas">

    <button type="submit">
        Listo
    </button>

</form>

    
    <div class="circulo c1"></div>
    <div class="circulo c2"></div>
    <div class="circulo c3"></div>
    <div class="circulo c4"></div>
    <div class="circulo c5"></div>

</div>

</body>
</html>