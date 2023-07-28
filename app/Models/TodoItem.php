<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_name',
        'image',
        'registration_date',
        'expire_date',
        'finished_date',
        'is_deleted',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    
}