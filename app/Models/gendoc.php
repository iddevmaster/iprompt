<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class gendoc extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'book_num',
        'submit_by',
        'created_date',
        'type',
        'title',
        'bcreater',
        'binspector',
        'bapprover',
        'detail',
    ];
}
