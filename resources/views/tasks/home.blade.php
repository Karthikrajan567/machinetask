@extends('layouts.app')

@section('content')

<div class="d-flex">
    <h2>Task Details</h2>
    @if ($members->count() == 0)
        <button class="btn btn-primary text-white mb-3" id="alert_button">Create Project</button>
    @else
        <a class="btn btn-primary text-white mb-3" href="{{ route('taskform') }}">Create Project</a>
    @endif
</div>
<div>
    <table class="table">
        <thead>
            <th>S.no</th>
            <th>Name</th>
            <th>Description</th>
            <th>End date</th>
            <th>Task status</th>
            <th>Member</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $task->task_name }}</td>
                <td>{{ $task->task_description }}</td>
                <td>{{ $task->task_end_date }}</td>
                <td>{{ $task->task_status }}</td>
                <td>{{ $task->member->name ?? '' }}</td>
                <td>
                    <a href="{{ route('taskform', $task->id) }}" class="btn btn-primary">Edit</a>
                    <x-common.button class="btn btn-danger" data-task-id="{{ $task->id }}" id="task_delete">Delete</x-common.button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@section('js')
<script>
    $('#alert_button').click(function() {
        Swal.fire({
        title: "Please Create atleast one Member",
        showClass: {
            popup: `
            animate__animated
            animate__fadeInUp
            animate__faster
            `
        },
        hideClass: {
            popup: `
            animate__animated
            animate__fadeOutDown
            animate__faster
            `
        }
        });
    });
    // delete ajax
    $('#task_delete').click(function() {
        // Get the task id from the data attribute
        var taskId = $(this).data('task-id');
        // Send an AJAX request to the route with the task id
        $.ajax({
            url: '{{ route("taskdelete", ":taskId") }}'.replace(':taskId', taskId),
            type: 'GET',
            heders: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
               window.location.reload();
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(error);
            }
        });
    });
</script>
@endsection
