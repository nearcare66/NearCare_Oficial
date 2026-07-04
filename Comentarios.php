<?php
session_start();
$isLoggedIn = isset($_SESSION['usuario_id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>NearCare</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="Css/styles5.css">
  <link rel="stylesheet" href="Css/session-menu.css">
  <link rel="stylesheet" href="Css/botones-globales.css?v=2">
</head>
<body>
    <main>

    <header class="navbar">
    <?php if ($isLoggedIn): ?>
      <button class="menu-icon" type="button" aria-label="Abrir menu" aria-controls="sideMenu" aria-expanded="false">
        &#9776;
      </button>
    <?php endif; ?>

  <div class="navbar-left">

      <a href="javascript:history.back()" class="back-arrow">&#8249;</a>

    <div class="logo">
      <img src="img/Designer (16).png" alt="">
    </div>
  </div>

  <div class="profile">
    <span class="welcome">Bienvenido</span>
  </div>

  </header>
    <?php include "php/menu-lateral.php"; ?>

    <div class="bg-bubbles">
    <div class="b1"></div>
    <div class="b2"></div>
    <div class="b3"></div>
    <div class="b4"></div>

    <!-- nuevas -->
    <div class="b5"></div>
    <div class="b6"></div>
    <div class="b7"></div>
    <div class="b8"></div>
    <div class="b9"></div>
    </div>
    <div class="container">


        <div class="info-bar">
            NearCare agradecerá tu opinión sobre nuestros trabajo y que podemos implementar
        </div>

        
      <form id="formComentario">

          <div class="comment-box">
              <textarea name="comentario" placeholder="Escribe tu comentario..." required></textarea>
          </div>

          <button type="submit" class="btn-enviar">Enviar</button>

        </form>

        <!-- NOTIFICACIÓN -->
        <div id="notificacion" class="noti">✅ Comentario enviado</div>

    </div>

    <?php if ($isLoggedIn): ?>
      <script src="menu.js"></script>
    <?php endif; ?>
    <script>
      document.getElementById("formComentario").addEventListener("submit", function(e) {
          e.preventDefault();

          let formData = new FormData(this);

          fetch("php/Comentarios-guardado.php", { // ✅ RUTA CORRECTA
              method: "POST",
              body: formData
          })
          .then(res => res.text())
          .then(data => {

              console.log("Respuesta:", data);

              if (data.trim() === "ok") {

                  let noti = document.getElementById("notificacion");

                  noti.classList.add("show");

                  setTimeout(() => {
                      noti.classList.remove("show");
                  }, 3000);

                  document.querySelector("textarea").value = "";

              } else {
                  alert("Error del servidor:\n" + data);
              }

          })
          .catch(error => {
              alert("Error de conexión:\n" + error);
          });
      });
    </script>
</body>
</html>
