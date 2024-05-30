<?php

namespace Controllers;

use Classes\Paginacion;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Model\Ponente;
use MVC\Router;

class PonentesController {
    public static function index(Router $router) {
        isAdmin();

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/ponentes?page=1');
            exit();
        }

        $registros_por_pagina = 5;
        $total                = Ponente::total();
        $paginacion           = new Paginacion($pagina_actual, $registros_por_pagina, $total);

        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/ponentes?page=1');
            exit();
        }

        $ponentes = Ponente::paginar($registros_por_pagina, $paginacion->offset());

        $router->render('/admin/ponentes/index', [
            'titulo'     => 'Ponentes / Conferencistas',
            'ponentes'   => $ponentes,
            'paginacion' => $paginacion->paginacion(),
        ]);
    }

    public static function crear(Router $router) {

        isAdmin();

        $alertas = [];
        $ponente = new Ponente;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            isAdmin();

            // Leer imagen
            if (!empty($_FILES['imagen']['tmp_name'])) {

                $carpeta_imagenes = '../public/img/speakers';

                // Crear la carpeta si no existe
                if (!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                $manager     = new ImageManager(new Driver());
                $imagen_png  = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 800)->toPng();
                $imagen_webp = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 800)->toWebp(60);
                $imagen_avif = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 800)->toAvif(60);

                $nombre_imagen = md5(uniqid(rand(), true));

                $_POST['imagen'] = $nombre_imagen;
            }
            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);
            $ponente->sincronizar($_POST);

            // validar
            $alertas = $ponente->validar();

            // Guardar el registro
            if (empty($alertas)) {

                // Guardar las imagenes
                $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");
                $imagen_avif->save($carpeta_imagenes . '/' . $nombre_imagen . ".avif");

                // Guardar en la BD
                $resultado = $ponente->guardar();

                if ($resultado) {
                    header('Location: /admin/ponentes');
                }
            }
        }

        $router->render('admin/ponentes/crear', [
            'titulo'  => 'Registrar Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes'   => json_decode($ponente->redes),
        ]);
    }

    public static function editar(Router $router) {

        isAdmin();

        $alertas = [];
        // Validar ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /admin/ponentes');
        }

        $ponente = Ponente::find($id);

        if (!$ponente) {
            header('Location: /admin/ponentes');
        }

        $ponente->imagen_actual = $ponente->imagen;

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            isAdmin();
            if (!empty($_FILES['imagen']['tmp_name'])) {

                $carpeta_imagenes = '../public/img/speakers';

                // Crear la carpeta si no existe
                if (!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                $manager     = new ImageManager(new Driver());
                $imagen_png  = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 800)->toPng();
                $imagen_webp = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 800)->toWebp(60);
                $imagen_avif = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 800)->toAvif(60);

                $nombre_imagen = md5(uniqid(rand(), true));

                $_POST['imagen'] = $nombre_imagen;
            } else {
                $_POST['imagen'] = $ponente->imagen_actual;
            }

            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);
            $ponente->sincronizar($_POST);

            $alertas = $ponente->validar();

            if (empty($alertas)) {
                if (isset($nombre_imagen)) {
                    // Guardar las imagenes
                    $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                    $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");
                    $imagen_avif->save($carpeta_imagenes . '/' . $nombre_imagen . ".avif");
                }

                $resultado = $ponente->guardar();

                if ($resultado) {
                    header('Location: /admin/ponentes');
                }
            }
        }

        $router->render('/admin/ponentes/editar', [
            'titulo'  => 'Actualizar Ponente',
            'ponente' => $ponente,
            'alertas' => $alertas,
            'redes'   => json_decode($ponente->redes),
        ]);
    }

    public static function eliminar() {
        isAdmin();

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            isAdmin();
            $id      = $_POST['id'];
            $ponente = Ponente::find($id);

            if (!isset($ponente)) {
                header('Location: /admin/ponentes');
                exit();
            }

            $resultado = $ponente->eliminar();
            if ($resultado) {
                header('Location: /admin/ponentes');
                exit();
            }
        }
    }
}
