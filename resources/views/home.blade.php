@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div id="status-message" class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Hello!,') }}
                    <h1>{{ Auth::user()->name }}</h1>
                    <h4>Your Tasks</h4>
                    @if($tasks->isEmpty())
                        <p>No tasks found.</p>
                    @else
                        <ul class="list-group py-1">
                            @foreach($tasks as $task)
                                <li class="list-group-item d-flex align-items-center justify-content-between px-2">
                                    <div>
                                        <strong>{{ $task->title }}</strong> - {{ $task->description }}
                                        <span class="badge {{ $task->status == 'pending' ? 'text-danger' : 'text-primary' }}">
                                            {{ $task->status }}
                                        </span>
                                        <br>
                                        <small>Due Date: {{ $task->due_date }}</small><br>
                                        <small>Priority: {{ $task->priority }}</small>
                                    </div>
                                    @if($task->status == 'pending')
                                     <button class="btn btn-success btn-sm mark-done" data-task-id="{{ $task->id }}">Done</button>
                                    @else
                                     <button class="btn btn-warning btn-sm mark-pending" data-task-id="{{ $task->id }}">Pending</button>
                                    @endif
                                    <button class=" delete-task btn btn-danger btn-sm" data-id="{{ $task->id }}">delete</button>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="pt-3">
                        <h2>Add New Task</h2>
                    <form action="{{route('task.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="due_date">Due Date</label>
                            <input type="date" name="due_date" id="due_date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="priority">Priority</label>
                            <select name="priority" id="priority" class="form-control">
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Add Task</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.mark-done').forEach(button => {
            button.addEventListener('click', function () {
                let taskId = this.getAttribute('data-task-id');
                fetch(`/tasks/${taskId}/mark-done`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    }
                });
            });
        });

        document.querySelectorAll('.mark-pending').forEach(button => {
            button.addEventListener('click', function () {
                let taskId = this.getAttribute('data-task-id');
                fetch(`/tasks/${taskId}/mark-pending`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    }
                });
            });
        });
    });
    $(document).ready(function() {
    $('.delete-task').click(function() {
        var taskId = $(this).data('id');

        // Confirm deletion (optional)
        if (confirm('Are you sure you want to delete this task?')) {
            $.ajax({
                url: '/delete-task/' + taskId,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response);
                    window.location.reload();

                    alert('Task deleted successfully.');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('Failed to delete task. Please try again.');
                }
            });
        }
    });
});



</script>
@endsection
