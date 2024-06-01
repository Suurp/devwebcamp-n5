<header class="header">
    <div class="header__contenedor">
        <nav class="header__navegacion">
            <?php if (isAuth()) {?>
                <a href="<?=isAdmin() ? '/admin/dashboard' : '/finalizar-registro';?>" class="header__enlace">Administrar</a>
                <form action="/logout" method="POST" class="header__form">
                    <input type="submit" value="Cerrar Sesión" class="header__submit--logout">
                </form>
            <?php } else {?>
                <a href="/registro" class="header__enlace">Registro</a>
                <a href="/login" class="header__enlace">Iniciar Sesión</a>
            <?php }?>
        </nav>

        <div class="header__contenido">
            <a href="/">
                <h1 class="header__logo">&#60;DevWebCamp /></h1>
                <p class="header__texto">Octubre 5-6 2023</p>
                <p class="header__texto header__texto--modalidad">En Linea - Presencial</p>

                <a href="/registro" class="header__boton">Comprar Pase</a>
            </a>
        </div>
    </div>
</header>

<div class="barra">
    <div class="barra__contenido">
        <a href="/">
            <h2 class="barra__logo">&#60;DevWebCamp /></h2>
        </a>
        <nav class="navegacion">
            <a href="/devwebcamp" class="navegacion__enlace <?=paginaActual('/devwebcamp') ? 'navegacion__enlace--actual' : '';?>">Evento</a>
            <a href="/paquetes" class="navegacion__enlace <?=paginaActual('/paquetes') ? 'navegacion__enlace--actual' : '';?>"">Paquetes</a>
            <a href="/workshop-conferencias" class="navegacion__enlace <?=paginaActual('/workshop-conferencias') ? 'navegacion__enlace--actual' : '';?>"">Workshops / Conferencias</a>
            <a href="/registro" class="navegacion__enlace <?=paginaActual('/registro') ? 'navegacion__enlace--actual' : '';?>"">Comprar Pase</a>
        </nav>
    </div>
</div>