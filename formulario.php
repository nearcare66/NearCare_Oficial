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
    <link rel="stylesheet" href="Css/session-menu.css"> 
  <link rel="stylesheet" href="Css/botones-globales.css?v=1">
</head>
<body>

    <nav class="navbar">
        <div class="nav-left">
            <span class="menu-icon"></span> 
            <img src="img/Designer (16).png" alt="Logo NearCare" class="logo">
        </div>

        <div class="nav-right">
           
            <span class="avatar" aria-hidden="true"></span>
            <div class="bienvenido">
                <span>Bienvenido</span>
            </div>
        </div>
    </nav>

    <div class="contenedor">

        <h1>Registrar paciente</h1>


        <form method="POST">

            <label>ID de paciente *</label>
            <input type="text" name="id_paciente" placeholder="">

            <label>Nombre completo del paciente *</label>
            <input type="text" name="nombre" placeholder="">

            <label>Edad actual *</label>
            <input type="text" name="edad" placeholder="">

            <label>Género *</label>
            <select name="genero">
                <option>Seleccione una opción</option>
                <option>Masculino</option>
                <option>Femenino</option>
            </select>

            <label>Condición del paciente *</label>
            <input type="text" name="condicion" placeholder="">

            <label>Médico responsable *</label>
            <input type="text" name="medico" placeholder="">

            <label>Hora de atención *</label>
            <input type="time" name="">

            <label>Horario de visitas *</label>
            <input type="text" name="visitas" placeholder="">

            <button type="submit">
                Registrar paciente
            </button>

        </form>
    </div>

   
    <div class="circulo c1"></div>
    <div class="circulo c2"></div>
    <div class="circulo c3"></div>
    <div class="circulo c4"></div>
    <div class="circulo c5"></div>

</body>
</html>
