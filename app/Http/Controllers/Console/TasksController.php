<?php

namespace App\Http\Controllers\Console;

use App\Models\Task;
use Illuminate\Http\Request;

class TasksController
{
    public function store(Request $request)
    {
        $request->validate(['task' => ['required', 'string', 'max:1000']]);

        $request->user()->tasks()->create([
            'content' => $request->task,
        ]);

        return back();
    }

    public function complete(Task $task)
    {
        $task->complete();

        return back();
    }
}
