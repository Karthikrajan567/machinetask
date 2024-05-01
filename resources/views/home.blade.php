@extends('layouts.app')

@section('content')

@role('admin')
    <p>Admin Login</p>
@endrole

@role('manager')
    <p>project manager Login</p>
@endrole

@role('member')
    <p>User </p>
@endrole


@endsection
