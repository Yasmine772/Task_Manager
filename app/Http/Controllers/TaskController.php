<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function addCategoriesToTask(Request $request, $TaskId)
    {
        $task = Task::findOrFail($TaskId);
        $task->categories()->attach($request->category_id); 
        return response()->json('Category attached Successfully', 200);
    }
    public function getTaskCategory($taskId)
    {
        $task = Task::findOrFail($taskId)->categories;
        return response()->json($task, 200);
    }
    public function index()
    {
        $user = Auth::user()->tasks;
        //$alltasks = Task::all();
        return response()->json($user, 200);
    }

    public function store(StoreTaskRequest $request)
    {
        $user_id = Auth::user()->id;
        $ValidatedData = $request->validated();
        $ValidatedData['user_id'] = $user_id;
        $task = Task::create($ValidatedData);
        return response()->json($task, 201);
    }

    public function update(int $id, UpdateTaskRequest $request)
    {
        $user_id = Auth::user()->id;
        $task = Task::findOrfail($id);
        if ($task->user_id != $user_id)
            return response()->json(['message' => 'Unauthurized'], 403);
        $task->update($request->validated());
        return response()->json($task, 200);
    }
    public function show(int $id)
    {
        $task = Task::find($id);
        if ($task) {
            return response()->json($task, 200);
        }
        if (!$task) {
            return response()->json('the id you entered does not exist', 200);
        }
    }
    public function destroy(int $id)
    {
        $task = Task::find($id);
        if ($task) {
            $task->delete();
            $message = 'Information deleted successfuly';
            return response()->json($message, 200);
        }
        if (!$task) {
            return response()->json('the id you entered does not exist', 204);
        }
    }
    public function getTaskUser($id)
    {
        $user_id = Auth::user()->id;
        $user = Task::findOrFail($id)->user;
        if ($user->id != $user_id)
            return response()->json('Unauthurized', 403);
        return response()->json($user, 200);
    }
    public function getAllTasks()
    {
        $alltasks = Task::all();
        return response()->json($alltasks, 200);
    }
}
