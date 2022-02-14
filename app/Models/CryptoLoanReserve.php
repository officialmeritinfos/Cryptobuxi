<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryptoLoanReserve extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table=['loan_reserves'];
}
