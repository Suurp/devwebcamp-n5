<?php

foreach ($alertas as $key => $alerta) {
    foreach ($alerta as $mensaje) {
?>

        <div class="alerta alerta__<?= $key; ?>"><?= $mensaje; ?></div>

<?php
    }
}
?>