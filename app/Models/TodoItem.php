<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TodoItemRequest;

class TodoItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
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
     * 期限日が古い順に並べ替え、削除されていないレコードを全件取得
     * @return array
     */
    public function findAll() {
        return $this->orderBy('expire_date')->whereIsDeleted(0)->get();
    }

    /**
     * バリデーションチェック後の入力情報を受け取り、1件分のデータを登録
     * @param array $inputs
     */
    public function insert($inputs) {
        $this->item_name = $inputs['item_name'];
        $this->registration_date = now()->format('Y-m-d');
        $this->expire_date = $inputs['expire_date'];
        $this->user_id = auth()->user()->id;

        if (request('image')) {
            $name = request()->file('image')->getClientOriginalName();
            request()->file('image')->move('storage/images', $name);
            $this->image = $name;
        }

        DB::beginTransaction();
        try {
            $this->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    /**
     * バリデーションチェック後の入力情報、リクエスト、todoItemを受け取り、指定したtodoItemを更新
     * @param array $inputs
     * @param TodoItemRequest $request
     * @param TodoItem $todo
     */
    public function updateTodoItem($inputs, TodoItemRequest $request, TodoItem $todo) {
        $todo->item_name = $inputs['item_name'];
        $todo->expire_date = $inputs['expire_date'];
        $todo->finished_date = $request->finished_date == 1 ? now()->format('Y-m-d') : null;
        $todo->user_id = auth()->user()->id;

        if (request('image')) {
            $name = request()->file('image')->getClientOriginalName();
            request()->file('image')->move('storage/images', $name);
            $todo->image = $name;
        }

        DB::beginTransaction();
        try {
            $todo->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    /**
     * 指定したtodoItemを論理削除
     * @param TodoItem $todo
     */
    public function deleteTodoItem(TodoItem $todo) {
        $todo->is_deleted = 1;
        $todo->user_id = auth()->user()->id;

        DB::beginTransaction();
        try {
            $todo->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
    
    /**
     * 指定したtodoItemの完了日に日付を入れる
     * @param TodoItem $todo
     */
    public function completeTodoItem(TodoItem $todo) {
        $todo->finished_date = now()->format('Y-m-d');

        DB::beginTransaction();
        try {
            $todo->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    /**
     * ログイン中のユーザーと投稿したユーザーが一致か確認
     * @param TodoItem $todo
     * @return bool true | false
     */
    public function checkUser(TodoItem $todo) {
        if (auth()->user()->id === $todo->user_id) {
            return true;
        }
        return false;
    }

}