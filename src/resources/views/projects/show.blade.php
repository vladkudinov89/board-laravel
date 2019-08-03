@extends('layouts.app')

@section('content')
  <div class="flex items-center mb-3 py-4">
    <header class="flex justify-between w-full items-end">
      <p class="text-normal text-grey text-sm">
        <a class="font-normal text-grey text-sm no-underline" href="/projects">
          My Projects
        </a>
        / {{ $project->title }}
      </p>

      <div class="flex items-center">
        @foreach ($project->members as $member)
          <img
            src="{{ gravatar_url($member->email) }}"
            alt="{{ $member->name }}'s avatar"
            class="rounded-full w-8 mr-2">
        @endforeach

        <img
          src="{{ gravatar_url($project->owner->email) }}"
          alt="{{ $project->owner->name }}'s avatar"
          class="rounded-full w-8 mr-2">

        <a href="{{ $project->path().'/edit' }}" class="button ml-4">Edit Project</a>
      </div>
    </header>
  </div>
  <main>
    <div class="lg:flex -mx-3">
      <div class="lg:w-3/4 px-3 mb-6">
        <div class="mb-8">
          <h2 class="text-lg text-grey font-normal mb-3">
            Tasks
          </h2>

          @include('projects.tasks', ['project' => $project ,'tasks' => $project->tasks])

        </div>
        <div class="">
          <h2 class="text-lg text-grey font-normal mb-3">
            General Notes
          </h2>
          <form action="{{ $project->path() }}" method="POST">
            @csrf
            @method('PATCH')

            <textarea
              name="notes"
              class="card w-full"
              style="min-height: 200px"
              placeholder="Make note for a project"
            >{{ $project->notes  }}</textarea>

            <button type="submit" class="button">Save</button>
          </form>

          @include ('errors')

        </div>
      </div>
      <div class="lg:w-1/4 px-3">
        @include('projects.card')
        @include ('projects.activity.card')

        @can('manage' , $project)
          @include ('projects.invite' , [ 'project' => $project ] )
        @endcan

      </div>
    </div>
  </main>
@endsection
