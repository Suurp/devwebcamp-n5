<?php

function debuguear($variable): string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

function s($html): string {
    $s = htmlspecialchars($html);
    return $s;
}

function paginaActual(string $path): bool {
    // Verificar que $path no esté vacío
    if (empty($path)) {
        return false;
    }

    // Usar $_SERVER['REQUEST_URI'] para mayor compatibilidad
    $currentPath = $_SERVER['REQUEST_URI'] ?? '/';

    // Verificar si $path está contenido en la URI actual
    return str_contains($currentPath, $path);
}

function isAuth() {
    // Iniciar la sesión si aún no ha sido iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Regenerar el ID de sesión para prevenir ataques de secuestro de sesión
    if (!isset($_SESSION['CREATED'])) {
        $_SESSION['CREATED'] = time();
    } elseif (time() - $_SESSION['CREATED'] > 1800) { // 30 minutos
        session_regenerate_id(true);
        $_SESSION['CREATED'] = time();
    }

    // Verificar si el usuario está autenticado
    if (empty($_SESSION['nombre'])) {
        return false;
    } else {
        return true;
    }

}

function isAdmin() {
    // Iniciar la sesión si aún no ha sido iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Regenerar el ID de sesión para prevenir ataques de secuestro de sesión
    if (!isset($_SESSION['CREATED'])) {
        $_SESSION['CREATED'] = time();
    } elseif (time() - $_SESSION['CREATED'] > 1800) { // 30 minutos
        session_regenerate_id(true);
        $_SESSION['CREATED'] = time();
    }

    // Verificar si el usuario está autenticado
    if (empty($_SESSION['admin'])) {
        return false;
    } else {
        return true;
    }
}

function salAnimation(): void {
    $efectos = [
        'fade',
        'slide-up',
        'slide-down',
        'slide-left',
        'slide-righ',
        'zoom-in',
    ];

    $eases = [
        // 'easeOutCubic',
        // 'easeOutQuint',
        // 'easeOutBack',
        // 'easeOutExpo',
        'easeOutCirc',
        'easeInOutSine',
    ];

    $efecto = array_rand($efectos, 1);
    $ease   = array_rand($eases, 1);

    echo ' data-sal=' . $efectos[$efecto] . ' ';
    echo ' data-sal-delay="300" ';
    echo ' data-sal-easing=' . $eases[$ease] . ' ';
}
