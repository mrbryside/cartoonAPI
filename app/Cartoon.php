<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cartoon extends Model
{
    protected $table = 'cartoons';
    protected $primaryKey = 'cartoonID';
    public $timestamps = true;
}
