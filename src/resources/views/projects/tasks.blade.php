@foreach ($tasks as $task)
<div class="card mb-3">
    {{ $task->body }}
</div>
@endforeach
<div class="card mb-3">
    <form action="{{ $project->path() . '/tasks' }}" method="post">

        @csrf
        
        <input type="text" class="w-full" name="body" placeholder="Add a new task">
    </form>
</div>
