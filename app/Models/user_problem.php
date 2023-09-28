<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class user_problem extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'user_id',
        'prob_datail',
        'user_contact',
    ];
}
