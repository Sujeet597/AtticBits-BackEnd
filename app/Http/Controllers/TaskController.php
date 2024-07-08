<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use PhpParser\Node\Stmt\TryCatch;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class TaskController extends Controller
{
    public function store(Request $request)
{
    try {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
        ]);


        $user = Auth::user();

        $task = Task::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'priority' => $request->priority,
            'status' => 'pending',
        ]);

        activity()
            ->causedBy($user)
            ->performedOn($task)
            ->withProperties(['task' => $task->title])
            ->log('created a task');

        return redirect()->back()->with('status', 'Task added successfully!');
    } catch (\Exception $e) {

        return redirect()->back()->with('error', 'Failed to add task: ' . $e->getMessage());
    }
}

public function updateStatus($id)
{
    try {
        $user = Auth::user();
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['status' => 0, 'message' => 'Task not found'], 404);
        }


        $newStatus = ($task->status == 'completed') ? 'pending' : 'completed';
        $task->status = $newStatus;
        $task->save();

        activity()
            ->causedBy($user)
            ->performedOn($task)
            ->withProperties(['status' => $newStatus])
            ->log('updated task status');

        return response()->json(['status' => 1, 'message' => 'Task status updated successfully'], 201);
    } catch (\Exception $e) {
        return response()->json(['status' => 0, 'error' => 'Failed to update task. Please try again.'], 500);
    }
}
public function deleteTask($id)
{
    try {
        $task = Task::findOrFail($id);
        $task->delete();
        return redirect()->back()->with('success', 'Task deleted successfully');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to delete task. Please try again.');
    }
}
}
