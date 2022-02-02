<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;
    public $timestamps = false;
    Protected $table = 'rented_book';
    protected $fillable = [
        'u_id',
        'b_id',
        'rent_date',
        'return_date'
    ];
}
