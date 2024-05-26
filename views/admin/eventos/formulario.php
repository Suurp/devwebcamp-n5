<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información Evento</legend>

    <div class="formulario__campo">
        <label for="nombre" class="formulario__label">Nombre Evento</label>
        <input type="text" class="formulario__input" id="nombre" name="nombre" placeholder="Nombre Evento" value="<?= $evento->nombre ?>">
    </div>

    <div class="formulario__campo">
        <label for="descripcion" class="formulario__label">Descripción</label>
        <textarea class="formulario__textarea" id="descripcion" name="descripcion" placeholder="Descripcion Evento" rows="8"><?= $evento->descripcion ?></textarea>
    </div>

    <div class="formulario__campo">
        <label for="categoria" class="formulario__label">Categoria o Tipo de Evento</label>
        <select class="formulario__select" id="categoria" name="categoria_id">
            <option value="" disabled selected>-Seleccionar-</option>
            <?php foreach ($categorias as $categoria) { ?>
                <option <?= ($evento->categoria_id === $categoria->id ? 'selected' : '') ?> value="<?= $categoria->id ?>"><?= $categoria->nombre ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="formulario__campo">
        <label for="dia" class="formulario__label">Selecciona el día</label>

        <div class="formulario__radio">
            <?php foreach ($dias as $dia) { ?>
                <div>
                    <label for="<?= strtolower($dia->nombre) ?>"><?= $dia->nombre ?></label>
                    <input type="radio" id="<?= strtolower($dia->nombre) ?>" name="dia" value="<?= $dia->id ?>">
                </div>
            <?php } ?>
        </div>

        <input type="hidden" name="dia_id" value="">
    </div>


    <div class="formulario__campo" id="horas">
        <label class="formulario__label">Seleccionar Hora</label>
        <ul id="horas" class="horas">
            <?php foreach ($horas as $hora) { ?>
                <li data-hora-id="<?= $hora->id ?>" class="horas__hora horas__hora--deshabilitada"><?= $hora->hora ?></li>
            <?php } ?>
        </ul>
        <input type="hidden" name="hora_id" value="">
    </div>
</fieldset>

<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información Extra</legend>

    <div class="formulario__campo">
        <label for="ponentes" class="formulario__label">Ponente</label>
        <input type="text" class="formulario__input" id="ponentes" placeholder="Buscar Ponente">

        <ul id="listado-ponentes" class="listado-ponentes"></ul>

        <input type="hidden" name="ponente_id" value="">
    </div>

    <div class="formulario__campo">
        <label for="disponibles" class="formulario__label">Lugares Disponibles</label>
        <input type="number" min="1" class="formulario__input" id="disponibles" name="disponibles" placeholder="Ej. 20" value="<?= $evento->disponibles ?>">
    </div>
</fieldset>