<?php

namespace App\Http\Controllers;

use App\Models\TodoItem;
use Illuminate\Http\Request;

class TodoItemController extends Controller
{
    private $todo;
    
    public function __construct()
    {
        $this->todo = new TodoItem();
    }

    public function index()
    {
        $todos = $this->todo->findAllTodoItem();
        $user = auth()->user();
        return view('todo.index', compact('todos', 'user'));
    }

    public function create()
    {
        return view('todo.create');
    }

    public function store(Request $request)
    {
        $inputs = $request->validate([
            'item_name' => 'required | max:100',
            'expire_date' => 'required | max:1000',
            'image' => 'image | max:1024',
        ]);

        $this->todo->insert($inputs);
        return redirect()->route('todo.index')->with('message', 'TODOを作成しました');
    }

    public function show(TodoItem $todo)
    {
        return view('todo.show', compact('todo'));
    }

    public function edit(TodoItem $todo)
    {
        if (!$this->checkUser($todo)) {
            return redirect()->route('todo.index');
        }
        return view('todo.edit', compact('todo'));
    }

    public function update(Request $request, TodoItem $todo)
    {
        if (!$this->checkUser($todo)) {
            return redirect()->route('todo.index');
        }
        
        $inputs = $request->validate([
            'item_name' => 'required | max:100',
            'expire_date' => 'required | max:1000',
            'image' => 'image | max:1024',
        ]);

        $this->todo->updateTodoItem($inputs, $request);
        return redirect()->route('todo.index', $todo)->with('message', 'TODOを更新しました');
    }

    public function destroy(TodoItem $todo)
    {
        if (!$this->checkUser($todo)) {
            return redirect()->route('todo.index');
        }

        /** 論理削除を行う為、1にする */
        $todo->is_deleted = 1;
        $todo->user_id = auth()->user()->id;
        $todo->save();
        return redirect()->route('todo.index', $todo)->with('message', 'TODOを削除しました');
    }

    public function complete(TodoItem $todo)
    {
        if (!$this->checkUser($todo)) {
            return redirect()->route('todo.index');
        }

        $todo->finished_date = now()->format('Y-m-d');
        $todo->save();
        return redirect()->route('todo.index', $todo)->with('message', 'TODOを完了しました');
    }

    /**
     * ログイン中のユーザーと投稿したユーザーが一致か確認するメソッド
     * @param TodoItem $todo
     * @return bool true | false
     */
    private function checkUser(TodoItem $todo)
    {
        if (auth()->user()->id === $todo->user_id) {
            return true;
        }
        return false;
    }
}
