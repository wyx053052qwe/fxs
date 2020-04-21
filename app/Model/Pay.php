<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    protected $table = 'pay';
    protected $primaryKey = 'p_id';
    public $timestamps = false;
}
