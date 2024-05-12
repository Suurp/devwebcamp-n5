<main class="auth">
    <h2 class="auth__heading"><?= $titulo; ?></h2>
    <p class="auth_texto">Recupara tu acceso a DevWebcamp</p>

    <?php require_once __DIR__ . '/../templates/alertas.php' ?>

    <form action="/olvide" class="formulario" method="POST">

        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email</label>
            <input type="email" class="formulario__input" placeholder="Tu Email" id="email" name="email">
        </div>

        <input type="submit" value="Crear Cuenta" class="formulario__submit">
    </form>

    <div class="acciones">
        <a href="/login" class="acciones__enlace">¿Ya tienes una cuenta? Inicia Sesión</a>
        <a href="/registro" class="acciones__enlace">¿Aún no tienes cuenta? Obten una</a>
    </div>
</main>