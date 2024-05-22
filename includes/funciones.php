<?php

function debuguear($variable): string
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function s($html): string
{
    $s = htmlspecialchars($html);
    return $s;
}

function pagina_actual(string $path): bool
{
    // Verificar que $path no esté vacío
    if (empty($path)) {
        return false;
    }

    // Usar $_SERVER['REQUEST_URI'] para mayor compatibilidad
    $currentPath = $_SERVER['REQUEST_URI'] ?? '';

    // Verificar si $path está contenido en la URI actual
    return str_contains($currentPath, $path);
}

function is_auth(): void
{
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
    if (empty($_SESSION)) {
        header('Location: /');
        exit();
    }
}

function is_admin(): void
{
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
        header('Location: /');
        exit();
    }
}
