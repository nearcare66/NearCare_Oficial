<div class="mes-nav">

    <button type="button"
        onclick="cambiarMes(<?php echo $mes-1; ?>, <?php echo $anio; ?>)">
        ⬅
    </button>

    <span id="tituloMes">
        <?php echo $meses[$mes] . " " . $anio; ?>
    </span>

    <button type="button"
        onclick="cambiarMes(<?php echo $mes+1; ?>, <?php echo $anio; ?>)">
        ➡
    </button>

</div>