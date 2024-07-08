@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Admin Dashboard</h1>
        <div class="py-4">
            <button id="userManagerBtn" class="bottom-3 bg-emerald-500 rounded-4">User Manager</button>
            <button id="taskManagerBtn" class="bottom-3 bg-emerald-500 rounded-4">Tasks</button>
        </div>
        <div id="userTableContainer"></div>

        @if($activityLogs->isEmpty())
            <p>No activity logs found.</p>
        @else
        <table class="table">
            <thead>
                <tr>
                    <th>Causer</th>
                    <th>Description</th>
                    <th>Properties</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activityLogs as $log)
                    <tr>
                        <td>{{ $log->causer->name }}</td>
                        <td>{{ $log->description }}</td>
                        <td>{{ $log->properties->toJson() }}</td>
                        <td>{{ $log->created_at->diffForHumans() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

            {{ $activityLogs->links() }}
        @endif
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
                window.location.href = '{{ route("admin.userdata") }}';
            });
        });
        $(document).ready(function() {

          $('#taskManagerBtn').click(function() {
           window.location.href = '{{ route("admin.task") }}';
          });
        });
    </script>
@endpush
