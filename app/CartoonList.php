<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartoonList extends Model
{
    protected $table = 'cartoonlists';
    protected $primaryKey = 'id';
    public $timestamps = true;
}
