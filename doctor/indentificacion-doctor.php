<?php
// Tu lógica de negocio en PHP o procesamiento de datos puede ir aquí más adelante.
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NearCare - Doctor ID</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/identificacion-doctor.css">
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

    <div class="container">
        
        <header class="topbar">
            <div class="back" onclick="history.back()">‹</div>
            <div class="title">Si es un doctor ingrese su ID</div>
        </header>

        <main class="content">
            <h1 class="subtitle">Ingrese su ID</h1>
            
            <input type="text" class="input-box" placeholder="escribe su ID">
            
            <button class="btn">Listo</button>

            <div class="logo">
              <img src="../img/Designer (16).png" alt="NearCare">
            </div>
        </main>

        <div class="circle c1"></div>
        <div class="circle c2"></div>

        <div class="circle c3"></div>
        <div class="circle c4"></div>

        <div class="circle c5"></div>
        <div class="circle c6"></div>

    </div>

</body>
</html>
<?php
// Cierre del archivo PHP
?>
