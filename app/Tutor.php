<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    //
    protected $fillable = [
        'name', 'email', 'password','contact_number','image','college_id'
    ];
    protected $hidden = ['password'];
}
