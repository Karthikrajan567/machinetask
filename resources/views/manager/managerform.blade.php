@extends('layouts.app')

@section('content')
<form id="managerForm">
    @csrf
    <div class="row">
        <div class="col-12 mb-3">
            <label for="name" class="form-label">name</label>
            <x-common.input type="text" class="char-length-30 char-alphanumeric" name="name" id="name" value="{{ $user->name ?? old('name') }}"/>
                <span class="text-danger d-none err_msg" id="name_error"></span>
        </div>
        <div class="col-12 mb-3">
            <label for="email" class="form-label">Email</label>
            <x-common.input type="email" class="char-length-255" name="email" id="email" value="{{ $user->email ?? old('email') }}"/>
                <span class="text-danger d-none err_msg" id="email_error"></span>
        </div>
        <div class="col-12 mb-3">
            <label for="password" class="form-label">password</label>
            <x-common.input type="password" class="char-length-16" name="password" id="password"
                value="{{ $user->password ?? old('password') }}"/>
                <span class="text-danger d-none err_msg" id="password_error"></span>
        </div>
        @if($user == null)
        <div class="col-12 mb-3">
            <x-common.button type="submit" class="btn btn-primary">Submit</x-common.button>
        </div>
        @endif
    </div>
  </form>
 @endsection
 @section('js')
 <script>
    //  ajax
    $("#managerForm").on('submit', function(event){
        event.preventDefault();
        $('.err_msg').addClass('d-none');
        var formdata = new FormData(this);
        $.ajax({
            url: "{{ route('admin.managersave') }}",
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
