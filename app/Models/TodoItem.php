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

    /**
     * 期限日順に並べ替え、削除されていないレコードを全件取得
     * @return array
     */
    public function findAllTodoItem()
    {
        return $this->orderBy('expire_date')->whereIsDeleted(0)->get();
    }















}