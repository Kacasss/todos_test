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
    public function findAllTodoItem() {
        return $this->orderBy('expire_date')->whereIsDeleted(0)->get();
    }

    public function insert($inputs) {
        $this->item_name = $inputs['item_name'];
        $this->registration_date = now()->format('Y-m-d');
        $this->expire_date = $inputs['expire_date'];
        $this->user_id = auth()->user()->id;
        // $this->fill($request->all);

        if (request('image')) {
            $name = request()->file('image')->getClientOriginalName();
            request()->file('image')->move('storage/images', $name);
            $this->image = $name;
        }

        $this->save();
    }

    // 更新途中
    public function updateTodoItem($inputs, $request) {
        $this->item_name = $inputs['item_name'];
        $this->expire_date = $inputs['expire_date'];
        $this->finished_date = $request->finished_date == 1 ? now()->format('Y-m-d') : null;
        $this->user_id = auth()->user()->id;

        if (request('image')) {
            $name = request()->file('image')->getClientOriginalName();
            request()->file('image')->move('storage/images', $name);
            $this->image = $name;
        }

        $this->save();
    }




}