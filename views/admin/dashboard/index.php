<h2 class="dashboard__heading"><?=$titulo;?></h2>

<main class="bloques">
  <div class="bloques__grid">
    <div class="bloque">
      <h3 class="bloque__heading">Últimos registros</h3>

      <?php foreach ($registros as $registro) {?>
        <p class="bloque__texto">
          <?=$registro->usuario->nombre . " " . $registro->usuario->apellido;?>
        </p>

      <?php }?>
    </div>

    <div class="bloque">
      <h3 class="bloque__heading">Ingresos</h3>
      <p class="bloque__texto--cantidad">$ <?=$ingresos;?></p>
    </div>

    <div class="bloque">
      <h3 class="bloque__heading">Eventos con Menos Lugares Disponibles</h3>
      <?php foreach ($menosDisponibles as $evento) {?>
        <p class="bloque__texto">
          <?=$evento->nombre . " - " . $evento->disponibles . ' Disponibles';?>
        </p>
      <?php }?>
    </div>

    <div class="bloque">
      <h3 class="bloque__heading">Eventos con Más Lugares Disponibles</h3>
      <?php foreach ($masDisponibles as $evento) {?>
        <p class="bloque__texto">
          <?=$evento->nombre . " - " . $evento->disponibles . ' Disponibles';?>
        </p>
      <?php }?>
    </div>
  </div>
</main>