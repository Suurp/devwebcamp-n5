<main class="auth">
    <h2 class="auth__heading"><?= $titulo; ?></h2>
    <p class="auth_texto">Registrate en DevWebcamp</p>

    <?php require_once __DIR__ . '/../templates/alertas.php' ?>


    <form method="POST" action="/registro" class="formulario">
        <div class="formulario__campo">
            <label for="nombre" class="formulario__label">Nombre</label>
            <input type="text" class="formulario__input" placeholder="Tu Nombre" id="nombre" name="nombre" value="<?= $usuario->nombre ?>">
        </div>

        <div class="formulario__campo">
            <label for="apellido" class="formulario__label">Apellido</label>
            <input type="text" class="formulario__input" placeholder="Tu Apellido" id="apellido" name="apellido" value="<?= $usuario->apellido ?>">
        </div>

        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email</label>
            <input type="email" class="formulario__input" placeholder="Tu Email" id="email" name="email" value="<?= $usuario->email ?>">
        </div>

        <div class="formulario__campo">
            <label for="password" class="formulario__label">Password</label>
            <input type="password" class="formulario__input" placeholder="Tu Password" id="password" name="password">
        </div>

        <div class="formulario__campo">
            <label for="password2" class="formulario__label">Repetir Password</label>
            <input type="password" class="formulario__input" placeholder="Repetir Password" id="password2" name="password2">
        </div>

        <input type="submit" value="Crear Cuenta" class="formulario__submit">
    </form>

    <div class="acciones">
        <a href="/login" class="acciones__enlace">¿Ya tienes una cuenta? Inicia Sesión</a>
        <a href="/olvide" class="acciones__enlace">¿Olvidaste tu contraseña?</a>
    </div>
</main>