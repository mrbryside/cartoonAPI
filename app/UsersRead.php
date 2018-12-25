<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersRead extends Model
{
    protected $table = 'usersread';
    protected $primaryKey = 'id';
    public $timestamps = true;
}
