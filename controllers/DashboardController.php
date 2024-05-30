<?php

namespace Controllers;

use MVC\Router;

class DashboardController {

    public static function index(Router $router) {
        isAdmin();

        $router->render('/admin/dashboard/index', [
            'titulo' => 'Panel de Administración',
        ]);
    }
}
