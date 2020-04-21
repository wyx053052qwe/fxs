<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'a_id';
    public $timestamps = false;
    public static function getid()
    {
        $aid = session('aid');
        return $aid;
    }
    public static function getname()
    {
        $name = session('name');
        return $name;
;
    }
}
