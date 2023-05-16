@extends('admin::layout')
@section('content')
    {{$table->views()}}
    <form>
        <input type="hidden" name="page" value="{{ws_request('page')}}">
        {{$table->search_box( 'Search', 's' )}}
        {{$table->display()}}
    </form>
@endsection