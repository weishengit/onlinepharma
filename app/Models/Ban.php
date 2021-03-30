<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reason',
        'banned_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
