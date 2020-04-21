<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    protected $table = 'icon';
    protected $primaryKey = 'i_id';
    public $timestamps = false;
}
