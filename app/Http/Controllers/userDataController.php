<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class userDataController extends Controller
{

    public function getAlluser()
{
    try {
        $users = User::all();
        return view('admin.userdata', compact('users'));
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error fetching users: ' . $e->getMessage());
    }
}

public function deleteUser($id)
{
    $user = User::find($id);
    if ($user) {
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    } else {
        return redirect()->back()->with('error', 'User not found.');
    }

}

public function allTask()
{
    try {
        $tasks = Task::with('user')->get();
        return view('admin.tasks', compact('tasks'));
    } catch (\Exception $e) {
        Log::error('Failed to delete task: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Error fetching tasks: ' . $e->getMessage());
    }
}


}