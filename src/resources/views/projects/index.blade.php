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

    <modal name="hello-world" classes="bg-card p-4 rounded-lg" height="auto">

      <h1 class="font-normal text-center mb-16 text-2xl">Let’s start something new</h1>

      <div class="flex">
        <div class="flex-1 mr-4">

          <div class="mb-4">
            <label for="title" class="text-sm block mb-2">Title</label>
            <input type="text" id="title" class="border border-muted-light p-2 text-xs block w-full rounded">
          </div>

          <div class="mb-4">
            <label for="description" class="text-sm block mb-2">Description</label>
            <textarea rows="7" id="description"
                      class="border border-muted-light p-2 text-xs block w-full rounded"></textarea>
          </div>
        </div>
        <div class="flex-1 ml-4">

          <div class="mb-4">
            <label class="text-sm block mb-2">Need Some Task</label>
            <input type="text" class="border border-muted-light p-2 text-xs block w-full rounded"
                   placeholder="Task 1">
          </div>

          <div class="mb-4">
            <button class="inline-flex items-center text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" class="mr-3">
                <g fill="none" fill-rule="evenodd" opacity=".307">
                  <path stroke="#000" stroke-opacity=".012" stroke-width="0" d="M-3-3h24v24H-3z"></path>
                  <path fill="#000"
                        d="M9 0a9 9 0 0 0-9 9c0 4.97 4.02 9 9 9A9 9 0 0 0 9 0zm0 16c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7zm1-11H8v3H5v2h3v3h2v-3h3V8h-3V5z"></path>
                </g>
              </svg>

              <span>Add New Task Field</span>

            </button>
          </div>

        </div>
      </div>

      <footer class="flex justify-end">
        <button class="button mr-4 is-outlined">Cancel</button>
        <button class="button">Create Project</button>
      </footer>

    </modal>

    <a href="" @click.prevent="$modal.show('hello-world')">Show Modal</a>
  </main>
@endsection
