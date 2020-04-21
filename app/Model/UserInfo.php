<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $table = 'userinfor';
    protected $primaryKey = 'i_id';
    public $timestamps = false;
}
