<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_code',
        'note',
        'project_name'
    ];
}
