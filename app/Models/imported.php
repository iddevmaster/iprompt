<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class imported extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'type',
        'recoder',
        'receive_date',
        'book_number',
        'receiver',
        'receiver_dpm',
        'from',
        'book_subj',
        'respondent',
        'resp_date',
        'status',
        'note',
        'resp_time',
        'file',
        'receiver_agn',
        'receiver_brn',
    ];
}
