<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocActionReq extends Model
{
    use HasFactory;

    protected $fillable = [
        'dar_id',
        'doc_type',
        'book_num',
        'action_type',
        'created_by',
        'stat',
        'app',
        'ins',
        'files',
        'shares',
        'is_approved',
        'dpm',
        'request_by',
        'request_at',
        'doc_owner',
    ];

    public function getUser() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
