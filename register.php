<?php
include("conexion.php");

if(isset($_POST['registrar'])){

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $sql = "INSERT INTO usuarios_nuevos(nombre, correo, password)
        VALUES('$nombre','$correo','$password')";


    mysqli_query($conexion, $sql);

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>NearCare Registro</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>

    *{
      margin:0;
      padding:0;
      box-sizing:border-box;
      font-family:'Poppins',sans-serif;
    }

    body{
      background:#dff0ec;
      min-height:100vh;
      display:flex;
      justify-content:center;
      align-items:center;
      overflow:hidden;
      position:relative;
    }

    .register-container{
      width:400px;
      background:#dfeeea;
      padding:40px 30px;
      border-radius:25px;
      text-align:center;
      box-shadow:0 10px 30px rgba(0,0,0,0.1);
      z-index:2;
    }

    .register-container h1{
      color:#2d65b4;
      margin-bottom:30px;
      font-size:40px;
      font-weight:700;
    }

    form{
      display:flex;
      flex-direction:column;
      gap:18px;
    }

    input{
      padding:16px;
      border:none;
      border-radius:40px;
      background:#f1f1f1;
      outline:none;
      font-size:16px;
      text-align:center;
    }

    button{
      padding:16px;
      border:none;
      border-radius:40px;
      background:#38b66a;
      color:white;
      font-size:20px;
      font-weight:600;
      cursor:pointer;
      transition:0.3s;
    }

    button:hover{
      transform:scale(1.03);
    }

    .logo-bottom{
      position:absolute;
      bottom:40px;
    }

    .logo-bottom img{
      width:180px;
    }

    .circle{
      position:absolute;
      border-radius:50%;
      background:radial-gradient(circle,#3f5bb5,#243b84);
    }

    .circle1{
      width:170px;
      height:170px;
      top:-50px;
      left:-50px;
    }

    .circle2{
      width:90px;
      height:90px;
      top:120px;
      right:100px;
    }

    .circle3{
      width:55px;
      height:55px;
      right:250px;
      top:300px;
    }

    .circle4{
      width:110px;
      height:110px;
      bottom:40px;
      left:250px;
    }

    .circle5{
      width:220px;
      height:220px;
      bottom:-90px;
      right:-90px;
    }

  </style>

</head>
<body>

  <div class="circle circle1"></div>
  <div class="circle circle2"></div>
  <div class="circle circle3"></div>
  <div class="circle circle4"></div>
  <div class="circle circle5"></div>

  <div class="register-container">
    <h1>Registrarse</h1>

    <form method="POST">

      <input type="text" name="nombre" placeholder="Escribe tu nombre" required>

      <input type="email" name="correo" placeholder="Escribe tu correo" required>

      <input type="password" name="password" placeholder="Crea una contraseña" required>

      <button type="submit" name="registrar">
        Registrarse
      </button>

    </form>

  </div>

  <div class="logo-bottom">
    <img src="img/Designer (16).png" alt="">
  </div>

</body>
</html>