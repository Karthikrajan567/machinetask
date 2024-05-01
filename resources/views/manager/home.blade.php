@extends('layouts.app')

@section('content')

<div class="d-flex">
    <h2>Manager Details</h2>
    <a class="btn btn-primary text-white mb-3" href="{{ route('admin.managerform') }}">Create manager</a>
</div>
<form method="GET" action="{{ route('admin.managerview') }}" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search by name">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>
<div>
    <table class="table">
        <thead>
            <th>S.no</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach ($managers as $manager)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $manager->name }}</td>
                <td>{{ $manager->email }}</td>
                <td>
                    @if($manager->deleted_at == null)
                    <a href="{{ route('admin.managerform', $manager->id) }}" class="btn btn-primary">view</a>
                    <x-common.button class="btn btn-danger" data-manager-id="{{ $manager->id }}" id="manager_delete">Delete</x-common.button>
                    @else
                    <x-common.button class="btn btn-info" data-manager-id="{{ $manager->id }}" id="manager_restore">Restore</x-common.button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $managers->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
@section('js')
<script>
    // delete ajax
    $('#manager_delete').click(function() {
        // Get the task id from the data attribute
        var managerId = $(this).data('manager-id');
        // Send an AJAX request to the route with the manager id
        $.ajax({
            url: '{{ route("admin.managerdelete", ":managerId") }}'.replace(':managerId', managerId),
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
    $('#manager_restore').click(function() {
        // Get the task id from the data attribute
        var managerId = $(this).data('manager-id');
        // Send an AJAX request to the route with the manager id
        $.ajax({
            url: '{{ route("admin.managerrestore", ":managerId") }}'.replace(':managerId', managerId),
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
