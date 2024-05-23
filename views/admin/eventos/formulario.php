<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información Evento</legend>

    <div class="formulario__campo">
        <label for="nombre" class="formulario__label">Nombre Evento</label>
        <input type="text" class="formulario__input" id="nombre" name="nombre" placeholder="Nombre Evento">
    </div>

    <div class="formulario__campo">
        <label for="descripcion" class="formulario__label">Descripción</label>
        <textarea class="formulario__input" id="descripcion" name="descripcion" placeholder="Descripcion Evento" rows="8"></textarea>
    </div>

    <div class="formulario__campo">
        <label for="categoria" class="formulario__label">Categoria o Tipo de Evento</label>
        <select class="formulario__select" id="categoria" name="categoria_id">
            <option value="" disabled selected>-Seleccionar-</option>
            <?php foreach ($categorias as $categoria) { ?>
                <option value="<?= $categoria->id ?>"><?= $categoria->nombre ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="formulario__campo">
        <label for="categoria" class="formulario__label">Selecciona el día</label>

        <div class="formulario__radio">
            <?php foreach ($dias as $dia) { ?>
                <div>
                    <label for="<?= strtolower($dia->nombre) ?>"><?= $dia->nombre ?></label>
                    <input type="radio" id="<?= strtolower($dia->nombre) ?>" name="dia" value="<?= $dia->id ?>">
                </div>
            <?php } ?>
        </div>
    </div>



</fieldset>