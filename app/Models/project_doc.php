<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class project_doc extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'proj_code',
        'submit_by',
        'type',
        'title',
        'detail',
        'sign',
        'created_date',
        'shares',
        'files'

    ];

    public function getFilesAttribute($value)
    {
        return json_decode($value, true);
    }


}
