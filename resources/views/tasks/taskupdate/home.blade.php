@extends('layouts.app')

@section('content')

<div class="d-flex">
    <h2>Task Details</h2>
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
        </thead>
        <tbody>
            @foreach ($user as $userData)
                @foreach ($userData->task as $task)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $task->task_name }}</td>
                        <td>{{ $task->task_description }}</td>
                        <td>{{ $task->task_end_date }}</td>
                        <td>
                            <x-common.select class="border-0 border-bottom py-1 w-100 task_status_select" name="task_status" data-task-id="{{ $task->id }}">
                                <option hidden value="">Open this select menu</option>
                                    <option value="ToDo" {{ isset($task) && $task->task_status === 'ToDo' ? 'selected' : '' }}>ToDo</option>
                                    <option value="Inprogress" {{ isset($task) && $task->task_status === 'Inprogress' ? 'selected' : '' }}>Inprogress</option>
                                    <option value="Completed" {{ isset($task) && $task->task_status === 'Completed' ? 'selected' : '' }}>Completed</option>
                            </x-common.select>
                        </td>
                        <td>{{ $task->member->name ?? '' }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@section('js')
<script>
    $('.task_status_select').change(function() {
        // Get the task id from the data attribute
        var taskId = $(this).data('task-id');
        // Get the selected value
        var selectedValue = $(this).val();
        // Send an AJAX request to the route with the task id
        $.ajax({
            url: '{{ route("member.updatestatus", ":taskId") }}'.replace(':taskId', taskId),
            type: 'GET',
            data: {
                status: selectedValue
            },
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


</script>
@endsection
