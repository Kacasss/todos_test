<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoItemRequest;
use App\Models\TodoItem;
use Illuminate\Http\Request;

class TodoItemController extends Controller {
    private $todo;
    
    public function __construct(TodoItem $todoItem) {
        $this->todo = $todoItem;
    }

    public function index() {
        $todos = $this->todo->findAllTodoItem();
        $user = auth()->user();
        return view('todo.index', compact('todos', 'user'));
    }

    public function create() {
        return view('todo.create');
    }

    public function store(TodoItemRequest $request) {
        $inputs = $request->all();
        $this->todo->insert($inputs);
        return redirect()->route('todo.index')->with('message', 'TODOを作成しました');
    }

    public function show(TodoItem $todo) {
        return view('todo.show', compact('todo'));
    }

    public function edit(TodoItem $todo) {
        if (!$this->todo->checkUser($todo)) {
            return redirect()->route('todo.index');
        }
        return view('todo.edit', compact('todo'));
    }

    public function update(TodoItemRequest $request, TodoItem $todo) {
        if (!$this->todo->checkUser($todo)) {
            return redirect()->route('todo.index');
        }

        $inputs = $request->all();
        $this->todo->updateTodoItem($inputs, $request, $todo);
        return redirect()->route('todo.index', $todo)->with('message', 'TODOを更新しました');
    }

    public function destroy(TodoItem $todo) {
        if (!$this->todo->checkUser($todo)) {
            return redirect()->route('todo.index');
        }

        $todo->is_deleted = 1;
        $todo->user_id = auth()->user()->id;
        $todo->save();
        return redirect()->route('todo.index', $todo)->with('message', 'TODOを削除しました');
    }

    public function complete(TodoItem $todo) {
        if (!$this->todo->checkUser($todo)) {
            return redirect()->route('todo.index');
        }

        $todo->finished_date = now()->format('Y-m-d');
        $todo->save();
        return redirect()->route('todo.index', $todo)->with('message', 'TODOを完了しました');
    }

}
