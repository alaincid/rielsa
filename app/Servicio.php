<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable = ['id', 'id_usuario', 'id_cliente', 'referencia', 'tipo_equipo', 'tipo_servicio', 'imagen_inicio', 'imagen_fin', 'id_reporte', 'pdf_reporte', 'fecha_inicio', 'fecha_final', 'status'];
}
