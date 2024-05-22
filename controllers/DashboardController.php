<?php

namespace Controllers;

use MVC\Router;

class DashboardController
{

    public static function index(Router $router)
    {
        is_auth();

        $router->render('/admin/dashboard/index', [
            'titulo' => 'Panel de Administración'
        ]);
    }
}
