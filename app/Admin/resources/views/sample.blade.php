@extends('admin::layout')
@section('content')
    <h2>This is sample page you can remove it in {{ws_app_path('Admin/admin.php')}}</h2>
    <form method="post">
        @csrf
        <input type="hidden" name="action" value="save">
        <label>Name</label>
        <input type="text" name="name" value="{{ws_old('name')}}">
        @error('name')
            <p style="color: red">{{$message}}</p>
        @enderror
        <button type="submit">Submit</button>
    </form>
@endsection