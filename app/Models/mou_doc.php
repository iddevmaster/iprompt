<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class mou_doc extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'submit_by',
        'type',
        'title',
        'party1',
        'parties',
        'place',
        'detail',
        'sign',
        'created_date',
    ];
}
