<?php
session_start();
require_once __DIR__ . '/php/saludo.php';

$isLoggedIn = isset($_SESSION['usuario_id']);
$saludo = nearcare_saludo($_SESSION['usuario'] ?? $_SESSION['registro_nombre'] ?? $_SESSION['nombre'] ?? '');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NearCare - Comentarios</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="Css/styles5.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="Css/session-menu.css">
  <link rel="stylesheet" href="Css/botones-globales.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="Css/dark-mode.css?v=1">
  <script src="dark-mode.js" defer></script>
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
        <a href="javascript:history.back()" class="back-arrow" aria-label="Regresar">&#8249;</a>

        <div class="logo">
          <img src="img/Designer (16).png" alt="NearCare">
        </div>
      </div>

      <div class="profile">
        <span class="welcome"><?php echo htmlspecialchars($saludo, ENT_QUOTES, 'UTF-8'); ?></span>
      </div>
    </header>

    <?php if ($isLoggedIn): ?>
      <?php include "php/menu-lateral.php"; ?>
    <?php endif; ?>

    <div class="bg-bubbles" aria-hidden="true">
      <div class="b1"></div>
      <div class="b2"></div>
      <div class="b3"></div>
      <div class="b4"></div>
      <div class="b5"></div>
      <div class="b6"></div>
      <div class="b7"></div>
      <div class="b8"></div>
      <div class="b9"></div>
    </div>

    <section class="container" aria-labelledby="comentarios-title">
      <h1 id="comentarios-title" class="sr-only">Comentarios</h1>

      <div class="info-bar">
        NearCare agradece tu opinion sobre nuestro trabajo y lo que podemos implementar.
      </div>

      <form id="formComentario">
        <div class="comment-box">
          <textarea name="comentario" placeholder="Escribe tu comentario..." required></textarea>
        </div>

        <button type="submit" class="btn-enviar">Enviar</button>
      </form>
    </section>

    <div id="notificacion" class="noti" role="status" aria-live="polite">Comentario enviado</div>
  </main>

  <?php if ($isLoggedIn): ?>
    <script src="menu.js"></script>
  <?php endif; ?>

  <script>
    const formComentario = document.getElementById("formComentario");
    const notificacion = document.getElementById("notificacion");

    formComentario.addEventListener("submit", (event) => {
      event.preventDefault();

      fetch("php/Comentarios-guardado.php", {
        method: "POST",
        body: new FormData(formComentario)
      })
        .then((response) => response.text())
        .then((data) => {
          if (data.trim() !== "ok") {
            alert("Error del servidor:\n" + data);
            return;
          }

          notificacion.classList.add("show");
          formComentario.reset();

          setTimeout(() => {
            notificacion.classList.remove("show");
          }, 3000);
        })
        .catch((error) => {
          alert("Error de conexion:\n" + error);
        });
    });
  </script>
</body>
</html>
