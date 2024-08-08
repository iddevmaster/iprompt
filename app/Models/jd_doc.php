<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class jd_doc extends Model
{
    use HasFactory, softDeletes;

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
        'shares',
        'files',
        'links',
        'edit_count',
        'stat',
        'app',
        'ins',
        'dpm',
    ];
}
