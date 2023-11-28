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
        'shares'
    ];

    public function getSharesAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getSubmit_byAttribute($value)
    {
        return json_decode($value, true);
    }
}
