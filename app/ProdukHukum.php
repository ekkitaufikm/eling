<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProdukHukum extends Model
{
  use SoftDeletes;
  
  protected $table = 'produk_hukum';
  protected $dates = ['deleted_at'];
  public $timestamps = false;
}