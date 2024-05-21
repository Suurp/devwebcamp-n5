<h2 class="dashboard__heading"><?= $titulo ?></h2>

<div class="dashboard__contenedor-boton">
    <a href="/admin/ponentes" class="dashboard__boton">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__formulario">
    <?php include_once __DIR__ . '/../../templates/alertas.php' ?>

    <form class="formulario" method="POST" enctype="multipart/form-data">
        <?php include_once __DIR__ . '/formulario.php' ?>

        <input type="submit" value="Actualizar ponente" class="formulario__submit formulario__submit--register">
    </form>
</div>