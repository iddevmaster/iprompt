<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'title',
        'party',
        'time_range',
        'note',
        'by',
        'files',
        'type',
        'book_num',
        'shares',
        'submit_by',
        'recurring',
    ];

    public function getUser() {
        return $this->belongsTo(User::class, 'by');
    }

    public function getFilesAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getRecurringAttribute($value)
    {
        return json_decode($value, true);
    }
}
