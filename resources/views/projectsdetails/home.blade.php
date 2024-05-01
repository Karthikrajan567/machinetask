@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between">
    <h2>Project Details</h2>
    @if ($members->count() == 0 || $managers->count() == 0)
        <button class="btn btn-danger text-white mb-3" id="alert_button">Create Project</button>
    @else
        <a class="btn btn-success text-white mb-3" href="{{ route('projectform') }}">Create Project</a>
    @endif
</div>
<form method="GET" action="{{ route('projectview') }}" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search by name">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>
<div>
    <table class="table">
        <thead>
            <th>Name</th>
            <th>Description</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Manager</th>
            <th>Memmber</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach ($projects as $project)
            <tr>
                <td>{{ $project->project_name }}</td>
                <td>{{ $project->project_description }}</td>
                <td>{{ $project->project_start_date }}</td>
                <td>{{ $project->project_end_date }}</td>
                <td>{{ $project->manager->name ?? '' }}</td>
                <td>{{ $project->member->name ?? '' }}</td>
                <td>
                    @if($project->deleted_at == null)
                    <a href="{{ route('projectform', $project->id) }}" class="btn btn-primary">Edit</a>
                    <x-common.button class="btn btn-danger" data-project-id="{{ $project->id }}" id="project_delete">Delete</x-common.button>
                    @else
                    <x-common.button class="btn btn-info" data-project-id="{{ $project->id }}" id="project_restore">Restore</x-common.button>
                    @endif
                </td>
            @endforeach
        </tbody>
    </table>
    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $projects->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
@section('js')
<script>
    $('#alert_button').click(function() {
        Swal.fire({
        title: "Please Create atleast one Manager and Member",
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
    $('#project_delete').click(function() {
        // Get the task id from the data attribute
        var projectId = $(this).data('project-id');
        // Send an AJAX request to the route with the project id
        $.ajax({
            url: '{{ route("projectdelete", ":projectId") }}'.replace(':projectId', projectId),
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
    // delete ajax
    $('#project_restore').click(function() {
        // Get the task id from the data attribute
        var projectId = $(this).data('project-id');
        // Send an AJAX request to the route with the project id
        $.ajax({
            url: '{{ route("projectrestore", ":projectId") }}'.replace(':projectId', projectId),
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
