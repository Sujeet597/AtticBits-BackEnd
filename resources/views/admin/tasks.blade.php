@extends('layouts.app')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <div class="container">
        <h1>Admin Dashboard</h1>
        <div class="py-4">
            <button id="userManagerBtn" class="bottom-3 bg-emerald-500 rounded-4">Activity Log</button>
            <button id="userdataManagerBtn" class="bottom-3 bg-emerald-500 rounded-4">user manage</button>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>UserName</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>priority</th>
                    <th>status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->user->name }}</td>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->priority }}</td>
                        <td>{{ $task->status }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {

                $('#userManagerBtn').click(function() {
                window.location.href = '{{ route("admin.index") }}';
            });
        });
        $(document).ready(function() {

        $('#userdataManagerBtn').click(function() {
        window.location.href = '{{ route("admin.userdata") }}';
        });
         });
       


    </script>
@endpush
