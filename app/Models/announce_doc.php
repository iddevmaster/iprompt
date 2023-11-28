<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class announce_doc extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'book_num',
        'submit_by',
        'created_date',
        'type',
        'title',
        'detail',
        'use_date',
        'anno_date',
        'sign',
        'sign_name',
        'sign_position',
        'shares'
    ];

    public function getSharesAttribute($value)
    {
        return json_decode($value, true);
    }
}
