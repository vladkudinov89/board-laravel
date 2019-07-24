@extends('layouts.app')

@section('content')

     <div class="flex items-center mb-3 py-4">
           <header class="flex justify-between w-full items-center">
              <h2 class="text-normal text-grey text-sm">My Projects</h2>

               <a href="/projects/create" class="button p-2 px-5">New Project</a>
           </header>
       </div>

       <main class="lg:flex lg:flex-wrap -mx-3">

           @forelse($projects as $project)
               <div class="lg:w-1/3 px-3 pb-6">
                 <div class="bg-white rounded-large shadow p-5" style="height: 200px">
                    <h3 class="font-normal text-xl py-4 mb-3 -ml-5 border-l-4 border-blue-light pl-4">
                      <a class="text-black no-underline" href="{{ $project->path() }}">{{ str_limit($project->title , 15 , '') }}</a>
                    </h3>
                   <div class="text-grey-dark text-sm">
                       {{ str_limit($project->description , 100 , '') }}
                   </div>
               </div>
               </div>
           @empty
               <p></p>No projects yet.
           @endforelse

       </main>
@endsection
