@extends('layouts.app')

@section('content')
<div class="flex items-center mb-3 py-4">
    <header class="flex justify-between w-full items-end">
      <h2 class="text-muted text-base font-light">My Projects</h2>
        <a class="button p-2 px-5" href="/projects/create">
            New Project
        </a>
    </header>
</div>
<main class="lg:flex lg:flex-wrap -mx-3">
    @forelse($projects as $project)
    <div class="lg:w-1/3 px-3 pb-6">
        @include('projects.card')
    </div>
    @empty
    <p>
        No projects yet.
    </p>
    @endforelse
</main>
@endsection
