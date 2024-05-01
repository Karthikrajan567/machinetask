@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between">
    <h2>Member Details</h2>
    <a class="btn btn-success text-white mb-3" href="{{ route('userform') }}">Create Member</a>
</div>
<form method="GET" action="{{ route('userview') }}" class="mb-3">
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
            @foreach ($members as $member)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $member->name }}</td>
                <td>{{ $member->email }}</td>
                <td>
                    @if($member->deleted_at == null)
                    <a href="{{ route('userform', $member->id) }}" class="btn btn-primary">view</a>
                    <x-common.button class="btn btn-danger" data-member-id="{{ $member->id }}" id="member_delete">Delete</x-common.button>
                    @else
                    <x-common.button class="btn btn-info" data-member-id="{{ $member->id }}" id="member_restore">Restore</x-common.button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $members->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
@section('js')
<script>
    // delete ajax
    $('#member_delete').click(function() {
        // Get the task id from the data attribute
        var memberId = $(this).data('member-id');
        // Send an AJAX request to the route with the member id
        $.ajax({
            url: '{{ route("userdelete", ":memberId") }}'.replace(':memberId', memberId),
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
    $('#member_restore').click(function() {
        // Get the task id from the data attribute
        var memberId = $(this).data('member-id');
        // Send an AJAX request to the route with the member id
        $.ajax({
            url: '{{ route("userrestore", ":memberId") }}'.replace(':memberId', memberId),
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
