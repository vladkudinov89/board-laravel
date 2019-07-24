@extends('layouts.app')

@section('content')
    <h2>Create new project</h2>
    <form class="form-horizontal" action="/projects" method="post">

        @csrf

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" placeholder="Title"/>
        </div>

        <label for="description">Description</label>
        <input type="text" class="form-control" name="description" placeholder="Description"/>

        <hr/>

        <input class="btn btn-primary" type="submit" value="Create">
    </form>
@endsection