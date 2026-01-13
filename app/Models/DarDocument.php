<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DarDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'dar_id',
        'doc_id',
        'doc_type',
        'status',
    ];
}
