<?php require_once __DIR__ . '/php/paciente-familiar-data.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Informacion del paciente</title>
  <link rel="stylesheet" href="Css/session-menu.css">
  <link rel="stylesheet" href="Css/paciente-familiar.css?v=3">
  <link rel="stylesheet" href="Css/botones-globales.css?v=1">
</head>
<body>
  <main class="page">
    <header class="navbar">
      <div class="nav-left">
        <a href="index.php" class="back-link" aria-label="Regresar al inicio">&#8249;</a>
        <img class="brand" src="img/Designer (16).png" alt="NearCare">
      </div>

      <h1 class="page-title">Informacion del paciente</h1>

      <div class="profile">
        <div class="user-icon" aria-hidden="true"></div>
        <div class="welcome-box">
          <span>Bienvenido</span>
          <div class="toggle" aria-hidden="true"></div>
        </div>
      </div>
    </header>

    <?php if ($isLoggedIn): ?>
      <?php include "php/menu-lateral.php"; ?>
    <?php endif; ?>

    <section class="content">
      <?php if ($paciente): ?>
        <article class="patient-card">
          <img src="<?php echo e($fotoPaciente); ?>" alt="Foto del paciente">
          <h2><?php echo e($paciente['nombre_completo']); ?></h2>
          <p>Nc<?php echo e($paciente['nc']); ?></p>
          <div class="doctor-name"><?php echo e($paciente['doctor_nombre']); ?></div>
        </article>

        <aside class="side-info">
          <div class="field-group">
            <div class="field-label">Condicion del paciente</div>
            <div class="field-value"><?php echo e($paciente['condicion_paciente']); ?></div>
          </div>

          <div class="field-group">
            <div class="field-label">Genero</div>
            <div class="field-value"><?php echo e($paciente['genero']); ?></div>
          </div>
        </aside>

        <div class="lower-row">
          <article class="date-card">
            <div class="section-label">Fecha de ingreso:</div>
            <div class="date-fields">
              <div class="date-box"><?php echo e($diaIngreso); ?></div>
              <span>/</span>
              <div class="date-box"><?php echo e($mesIngreso); ?></div>
              <span>/</span>
              <div class="date-box"><?php echo e($anioIngreso); ?></div>
            </div>
          </article>

          <article class="reason-card">
            <div class="section-label">Motivo de ingreso:</div>
            <div class="reason-value"><?php echo e($paciente['motivo_ingreso']); ?></div>
          </article>
        </div>

        <article class="diagnosis-card">
          <div class="section-label">diagnostico:</div>
          <div class="diagnosis-box"><?php echo nl2br(e($paciente['diagnostico_medico'])); ?></div>
        </article>

        <article class="calendar-card">
          <div class="section-label">Calendario</div>
          <div class="calendar">
            <h3>APRIL</h3>
            <div class="calendar-grid">
              <div class="day-name">SUN</div><div class="day-name">MON</div><div class="day-name">TUE</div><div class="day-name">WED</div><div class="day-name">THU</div><div class="day-name">FRI</div><div class="day-name">SAT</div>
              <div></div><div></div><div>1</div><div></div><div>4</div><div></div><div>2</div>
              <div>3</div><div class="event">Examen<br>de sangre</div><div>5</div><div>6</div><div>8</div><div>9</div><div>10</div>
              <div>11</div><div>12</div><div>13</div><div>14</div><div>15</div><div>16</div><div>17</div>
              <div>18</div><div>19</div><div>20</div><div>21</div><div class="event orange">Extraccion<br>del apendice<br>apendicitis</div><div>23</div><div>24</div>
              <div>25</div><div>26</div><div>27</div><div>28</div><div></div><div>30</div><div></div>
              <div></div><div></div><div></div><div></div><div></div><div></div><div></div>
            </div>
          </div>
        </article>

        <article class="call-card">
          <div class="call-button">Agendar llamada</div>
          <div class="call-time">9:30-10:30 AM</div>
        </article>

        <article class="schedule-card">
          <div class="schedule-box">
            <div>9:30-10:30 AM</div>
            <div>10:30-11:30 AM</div>
          </div>
        </article>
      <?php else: ?>
        <div class="message-card">
          <?php echo e($mensaje); ?>
          <br>
          <a href="registro2.php">Volver a ingresar el codigo</a>
        </div>
      <?php endif; ?>
    </section>
  </main>
  <?php if ($isLoggedIn): ?>
    <script src="menu.js"></script>
  <?php endif; ?>
</body>
</html>
