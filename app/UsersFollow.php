<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersFollow extends Model
{
    protected $table = 'usersfollow';
    protected $primaryKey = 'id';
    public $timestamps = true;
}
