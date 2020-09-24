<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $fillable = ['id', 'nombre_cliente', 'rfc_cliente', 'direccion_cliente', 'telefono_cliente', 'email_cliente'];
}
