<?php

namespace Controllers;

use MVC\Router;

class RegistradosController {

    public static function index(Router $router) {
        isAdmin();

        $router->render('/admin/registrados/index', [
            'titulo' => 'Usuarios Registrados',
        ]);
    }
}
