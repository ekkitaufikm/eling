<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lampiran extends Model
{
  use SoftDeletes;
  protected $table = 'lampiran';
  public $timestamps = false;
}
