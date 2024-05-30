<aside class="dashboard__sidebar">
    <nav class="dashboard__menu">
        <a href="/admin/dashboard" class="dashboard__enlace <?=paginaActual('/dashboard') ? 'dashboard__enlace--actual' : '';?>">
            <i class="fa-solid fa-house dashboard__icono"></i>
            <span class="dashboard__menu-texto">Inicio</span>
        </a>

        <a href="/admin/ponentes" class="dashboard__enlace <?=paginaActual('/ponentes') ? 'dashboard__enlace--actual' : '';?>">
            <i class=" fa-solid fa-microphone dashboard__icono"></i>
            <span class="dashboard__menu-texto">Ponentes</span>
        </a>

        <a href="/admin/eventos" class="dashboard__enlace <?=paginaActual('/eventos') ? 'dashboard__enlace--actual' : '';?>">
            <i class=" fa-solid fa-calendar-day dashboard__icono"></i>
            <span class="dashboard__menu-texto">Eventos</span>
        </a>

        <a href="/admin/registrados" class="dashboard__enlace <?=paginaActual('/registrados') ? 'dashboard__enlace--actual' : '';?>">
            <i class=" fa-solid fa-users dashboard__icono"></i>
            <span class="dashboard__menu-texto">Registrados</span>
        </a>

        <a href="/admin/regalos" class="dashboard__enlace <?=paginaActual('/regalos') ? 'dashboard__enlace--actual' : '';?>">
            <i class=" fa-solid fa-gift dashboard__icono"></i>
            <span class="dashboard__menu-texto">Regalos</span>
        </a>
    </nav>
</aside>