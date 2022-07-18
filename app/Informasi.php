<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    protected $table = 'tb_informasi';
    protected $primaryKey = 'id_informasi';
    public $timestamps = false;
}
