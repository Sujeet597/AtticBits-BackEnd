@extends('layouts.app')
@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <div class="container">
        <h1>Admin user Dashboard</h1>
        <div class="py-4">
            <button id="userManagerBtn" class="bottom-3 bg-emerald-500 rounded-4">Activity Log</button>
            <button id="taskManagerBtn" class="bottom-3 bg-emerald-500 rounded-4">Tasks</button>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created-At</th>
                    <th>updated-At</th>
                    <th>update</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                   <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                        <td><button class="px-4 bg-success-subtle py-2 rounded-5">Edit</button></td>
                        <td>
                            <button type="button" class="delete-btn bg-danger px-4 py-2 rounded-5" onclick="deleteUser({{ $user->id }})">Delete</button>
                        </td>
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

          $('#taskManagerBtn').click(function() {
           window.location.href = '{{ route("admin.task") }}';
          });
         });

         function deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
               fetch(`/user/${userId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    alert('User deleted successfully.');
                    window.location.reload();
                } else {
                    alert('Failed to delete user.');
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
                alert('Failed to delete user.');
            });
        }
    }

    </script>
@endpush
