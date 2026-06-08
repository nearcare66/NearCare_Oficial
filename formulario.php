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

    <nav class="navbar">
        <div class="nav-left">
            <span class="menu-icon">&#9776;</span> 
            <img src="img/Designer (16).png" alt="Logo NearCare" class="logo">
        </div>

        <div class="nav-right">
           
            <img src="img/avatar_hombre.png" alt="Usuario" class="avatar">
            <div class="bienvenido">
                <span>Bienvenido</span>
            </div>
        </div>
    </nav>

    <div class="contenedor">

        <h1>Registrar Paciente</h1>


        <form method="POST">

            <label>ID de paciente *</label>
            <input type="text" name="id_paciente" placeholder="Ingrese el ID">

            <label>Nombre completo del paciente *</label>
            <input type="text" name="nombre" placeholder="Ingrese el nombre">

            <label>Edad actual *</label>
            <input type="text" name="edad" placeholder="Ingrese la edad">

            <label>Género *</label>
            <select name="genero">
                <option>Seleccione una opción</option>
                <option>Masculino</option>
                <option>Femenino</option>
            </select>

            <label>Condición del paciente *</label>
            <input type="text" name="condicion" placeholder="Ingrese la condición">

            <label>Médico responsable *</label>
            <input type="text" name="medico" placeholder="Nombre del médico">

            <label>Hora de atención *</label>
            <input type="time" name="hora">

            <label>Horario de visitas *</label>
            <input type="text" name="visitas" placeholder="Ej: 1:00 PM - 4:00 PM">

            <button type="submit">
                Registrar Paciente
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
