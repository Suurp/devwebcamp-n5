<?php

namespace Controllers;

use Model\Categoria;
use Model\Dia;
use MVC\Router;

class EventosController
{

    public static function index(Router $router)
    {

        $router->render('/admin/eventos/index', [
            'titulo' => 'Conferencias y Workshop'
        ]);
    }

    public static function crear(Router $router)
    {
        $alertas = [];

        $categorias = Categoria::all('ASC');
        $dias = Dia::all('ASC');


        $router->render('/admin/eventos/crear', [
            'titulo' => 'Registrar Evento',
            'alertas' => $alertas,
            'categorias' => $categorias,
            'dias' => $dias
        ]);
    }
}
