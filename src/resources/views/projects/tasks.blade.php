@forelse ($tasks as $task)
    <li>{{ $task->body }}</li>
@empty
    <li>You haven't tasks.</li>
@endforelse
