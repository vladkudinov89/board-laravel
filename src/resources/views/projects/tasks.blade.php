@foreach ($tasks as $task)
<div class="card mb-3">
    <form action="{{ $task->path() }}" method="post">
        @method('PATCH')
        @csrf

         <div class="flex">
             <input type="text" name="body" value="{{ $task->body }}" class="text-default bg-card w-full {{ $task->completed ? 'line-through text-muted' : ''}}">
             <input type="checkbox" name="completed" onchange="this.form.submit()" {{$task->completed ? 'checked' : ''}}>
         </div>
    </form>

</div>
@endforeach
<div class="card mb-3">
    <form action="{{ $project->path() . '/tasks' }}" method="post">

        @csrf

        <input type="text" class="text-default bg-card w-full" name="body" placeholder="Add a new task">
    </form>
</div>
