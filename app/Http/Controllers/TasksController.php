<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->validate([
            'task_name' => 'required|string',
            'task_priority' => 'required|string'
        ]);

        $data['task_name'] = strip_tags($data['task_name']);
        $data['user_id'] = auth()->id();

        Task::create($data);

        return redirect('/dashboard')->with('status', 'Task created successfully!');
    }

    public function edit(Request $request)
    {
        $data = $request->validate([
            'task.*.task_name' => 'required|string',
            'task.*.task_priority' => 'required|string'
        ]);

        foreach ($data['task'] as $taskId => $taskData) {
            $task = Task::find($taskId);
            if ($task) {
                $task->update([
                    'task_name' => strip_tags($taskData['task_name']),
                    'task_priority' => $taskData['task_priority']
                ]);
            }
        }

        return response()->json(['success' => true]);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['success' => true]);
    }
}
