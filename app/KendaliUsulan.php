<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KendaliUsulan extends Model
{
  use SoftDeletes;
  protected $table = 'kendali_usulan';
  public $timestamps = false;
}
