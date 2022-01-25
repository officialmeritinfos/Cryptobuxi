<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwoWay extends Model
{
    use HasFactory;
    protected $table='two_way';
    protected $guarded=[];
}
