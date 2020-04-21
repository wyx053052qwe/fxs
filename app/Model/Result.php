<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'result';
    protected $primaryKey = 'r_id';
    public $timestamps = false;
}
