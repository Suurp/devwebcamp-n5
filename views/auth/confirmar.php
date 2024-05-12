<main class="auth">
    <h2 class="auth__heading"><?= $titulo; ?></h2>
    <p class="auth_texto">Tu cuenta DevWebCamp</p>

    <?php require_once __DIR__ . '/../templates/alertas.php' ?>

    <?php if (isset($alertas['exito'])) { ?>

        <div class="acciones acciones--centrar">
            <a href="/login" class="acciones__enlace">Iniciar Sesión</a>
        </div>

    <?php } ?>
</main>