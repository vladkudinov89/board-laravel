@extends('layouts.app')

@section('content')

     <div class="flex items-center justify-between">
           <h1>BirdBoard</h1>
           <div class="">
               <a href="/projects/create" class="btn btn-success">Create New Project</a>
           </div>
       </div>

       <ul>
           @forelse($projects as $project)
               <li>
                   <a href="{{$project->path()}}">{{$project->title}}</a>
               </li>
           @empty
               <p></p>No projects yet.
               <li class="form-group">
                   <p>Wan`t create project? </p> <a href="/projects/create" class="btn btn-success">Create</a>
               </li>
           @endforelse
       </ul>
@endsection