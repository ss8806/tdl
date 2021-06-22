<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Todo;

class TodoController extends Controller
{
  public function index()
  {
    $user = Auth::user();

    $todos = $user->todos()->orderBy('id', 'ASC')->get();
    return $todos;
  }

  public function add(Request $request, Todo $todo)
  {
    //$todo = new Todo(); インジェクションメソッドを使用してるのでいらない
    $user = Auth::user();
    $todo->user_id   = $user->id;
    $todo->text      = $request->input('text');
    $todo->ischecked = false;
    $todo->edit = false;
    $todo->save();
  }

  public function updateTodo(Request $request){
    Todo::where('id', $request->id)
    ->update(['text' => $request->text]);
  }
  
  public function changeIcon(Request $request){
    Todo::where('id', $request->id)
    ->update(['ischecked' => $request->ischecked]);
  } 

  public function destroyTodo(Request $request){
    Todo::where('id', $request->id)->delete();
    // $todos = Todo::all();
    // return $todos;
  } 
}
