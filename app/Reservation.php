<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'book_id',
        'user_id',
        'checked_out_at'
    ];


}
