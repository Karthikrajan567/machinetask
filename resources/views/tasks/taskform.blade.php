@extends('layouts.app')

@section('content')
<form id="taskForm">
    @csrf
    <div class="row">
        <x-common.input type="hidden" name="id" value="{{ $task->id ?? '' }}" />
        <div class="col-12 mb-3">
            <label for="task_name" class="form-label">name</label>
            <x-common.input type="text" class="char-length-30 char-alphanumeric" name="task_name" id="task_name"
            value="{{ $task->task_name ?? old('task_name') }}" />
                <span class="text-danger d-none err_msg" id="task_name_error"></span>
        </div>
        <div class="col-12 mb-3">
            <label for="task_description" class="form-label">Description</label>
            <x-common.input type="text" class="char-length-255" name="task_description" id="task_description"
            value="{{ $task->task_description ?? old('task_description') }}" />
                <span class="text-danger d-none err_msg" id="task_description_error"></span>
        </div>
        <div class="col-12 mb-3">
            <label for="task_end_date" class="form-label">End date</label>
            <x-common.input type="text" name="task_end_date" id="task_end_date"
            value="{{ isset($task) ? \Carbon\Carbon::parse($task->task_end_date)->format('m/d/Y') : old('task_end_date') }}"/>

                <span class="text-danger d-none err_msg" id="task_end_date_error"></span>
        </div>
        <div class="col-12 mb-3">
            <label for="end_date" class="form-label">Assign To Member</label>
            <x-common.select class="border-0 border-bottom py-1 w-100" name="task_member">
                <option hidden value="">Open this select menu</option>
                @foreach ($members as $member)
                    <option value="{{ $member->uuid }}"
                        {{ isset($task) && $task->task_member === $member->uuid ? 'selected' : '' }}
                        >{{ $member->name }}</option>
                @endforeach
            </x-common.select>
                <span class="text-danger d-none err_msg" id="task_member_error"></span>
        </div>
        <div class="col-12 mb-3">
            <label for="end_date" class="form-label">Task status</label>
            <x-common.select class="border-0 border-bottom py-1 w-100" name="task_status">
                <option hidden value="">Open this select menu</option>
                    <option value="ToDo" {{ isset($task) && $task->task_status === 'ToDo' ? 'selected' : '' }}>ToDo</option>
                    <option value="Inprogress" {{ isset($task) && $task->task_status === 'Inprogress' ? 'selected' : '' }}>Inprogress</option>
                    <option value="Completed" {{ isset($task) && $task->task_status === 'Completed' ? 'selected' : '' }}>Completed</option>
            </x-common.select>
                <span class="text-danger d-none err_msg" id="task_status_error"></span>
        </div>
        <div class="col-12 mb-3">
            <x-common.button type="submit" class="btn btn-primary">Submit</x-common.button>
        </div>
    </div>
  </form>
 @endsection
 @section('js')
 <script>
     $(function() {
        $('#task_end_date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minDate: moment().startOf('day'),
            maxYear: parseInt(moment().format('YYYY'),10)
        }, function(start, end, label) {
            var years = moment().diff(start, 'years');
        });
    });
    //  ajax
    $("#taskForm").on('submit', function(event){
        event.preventDefault();
        $('.err_msg').addClass('d-none');
        var formdata = new FormData(this);
        $.ajax({
            url: "{{ route('tasksave') }}",
            type: "POST",
            data: formdata,
            contentType: false,
            processData: false,
            success: function(res) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload(); // Reload the page after user confirms
                    }
                });
            },
            error: function(res)
            {
                var errors = res.responseJSON.errors;
                $.each(errors, function(key, value) {
                    $('#' + key + '_error').removeClass('d-none').text(value);
                });
            }
        });
    });
 </script>
 @endsection
