@extends('layouts.app')

@section('content')
<form id="projectForm">
    @csrf
    <div class="row">
        <x-common.input type="hidden" name="id" value="{{ $project->id ?? '' }}" />
        <div class="col-12 mb-3">
            <label for="project_name" class="form-label">name</label>
            <x-common.input type="text" class="char-length-30 char-alphanumeric" name="project_name" id="project_name"
            value="{{ $project->project_name ?? old('project_name') }}" />
                <span class="text-danger d-none err_msg" id="project_name_error"></span>
        </div>
        <div class="col-12 mb-3">
            <label for="project_description" class="form-label">description</label>
            <x-common.input type="text" class="char-length-255" name="project_description" id="project_description"
            value="{{ $project->project_description ?? old('project_description') }}" />
                <span class="text-danger d-none err_msg" id="project_description_error"></span>
        </div>
        <div class="col-12 mb-3">
            <label for="project_start_date" class="form-label">start & end date</label>
            <x-common.input type="text" name="project_start_date" id="project_start_date"
            value="{{ isset($project) && ($project->project_start_date && $project->project_end_date) ?
                \Carbon\Carbon::parse($project->project_start_date)->format('m/d/Y') . ' - ' .
                \Carbon\Carbon::parse($project->project_end_date)->format('m/d/Y') :
                old('project_start_date') }}"/>
                <span class="text-danger d-none err_msg" id="project_start_date_error"></span>
        </div>
        <div class="col-12 mb-3">
            <label for="end_date" class="form-label">Assign To Manager</label>
            <x-common.select class="border-0 border-bottom py-1 w-100" name="project_manager">
                <option hidden value="">Open this select menu</option>
                @foreach ($managers as $manager)
                    <option value="{{ $manager->uuid }}"
                        {{ isset($project) && $project->project_manager === $manager->uuid ? 'selected' : '' }}
                    >{{ $manager->name }}</option>
                @endforeach
            </x-common.select>
                <span class="text-danger d-none err_msg" id="project_manager_error"></span>
        </div>
        <div class="col-12 mb-3">
            <label for="end_date" class="form-label">Assign To Member</label>
            <x-common.select class="border-0 border-bottom py-1 w-100" name="project_member">
                <option hidden value="">Open this select menu</option>
                @foreach ($members as $member)
                    <option value="{{ $member->uuid }}"
                        {{ isset($project) && $project->project_member === $member->uuid ? 'selected' : '' }}
                        >{{ $member->name }}</option>
                @endforeach
            </x-common.select>
                <span class="text-danger d-none err_msg" id="project_member_error"></span>
        </div>
        <div class="col-12 mb-3">
            <x-common.button type="submit" class="btn btn-primary">Submit</x-common.button>
        </div>
    </div>
  </form>
 @endsection
 @section('js')
 <script>
     $('#project_start_date').daterangepicker();
    //  ajax
    $("#projectForm").on('submit', function(event){
        event.preventDefault();
        $('.err_msg').addClass('d-none');
        var formdata = new FormData(this);
        $.ajax({
            url: "{{ route('projectsave') }}",
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
