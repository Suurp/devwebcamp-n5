<?php

namespace Model;

class EventoHorario extends ActiveRecord
{
    protected static $tabla = 'eventos';
    protected static $columnasDB = ['id', 'categoria_id', 'dia_id', 'hora_id'];

    public $id;
    public $categoria_id;
    public $dia_id;
    public $hora_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->categoria_id = $args['categoria_id'] ?? '';
        $this->dia_id = $args['dia_id'] ?? '';
        $this->hora_id = $args['hora_id'] ?? '';
    }
}
