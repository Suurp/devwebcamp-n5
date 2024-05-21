<?php

namespace Controllers;

use Model\Ponente;
use MVC\Router;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PonentesController
{

    public static function index(Router $router)
    {
        $ponentes = Ponente::all();


        $router->render('/admin/ponentes/index', [
            'titulo' => 'Ponentes / Conferencistas',
            'ponentes' => $ponentes
        ]);
    }

    public static function crear(Router $router)
    {
        $alertas = [];
        $ponente = new Ponente;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Leer imagen
            if (!empty($_FILES['imagen']['tmp_name'])) {

                $carpeta_imagenes = '../public/img/speakers';

                // Crear la carpeta si no existe
                if (!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                $manager = new ImageManager(new Driver());
                $imagen_png = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 800)->toPng();
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
            'titulo' => 'Registrar Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => json_decode($ponente->redes)
        ]);
    }


    public static function editar(Router $router)
    {
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



        $router->render('/admin/ponentes/editar', [
            'titulo' => 'Actualizar Ponente',
            'ponente' => $ponente,
            'alertas' => $alertas,
            'redes' => json_decode($ponente->redes)
        ]);
    }
}
