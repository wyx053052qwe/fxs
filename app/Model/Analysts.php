<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Analysts extends Model
{
    protected $table = 'analysts';
    protected $primaryKey = 'a_id';
    public $timestamps = false;
}
