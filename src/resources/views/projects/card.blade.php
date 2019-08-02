<div class="card" style="height: 200px">
  <h3 class="font-normal text-xl py-4 mb-3 -ml-5 border-l-4 border-blue-light pl-4">
    <a class="text-black no-underline" href="{{ $project->path() }}">
      {{ $project->title }}
    </a>
  </h3>
  <div class="text-grey-dark text-sm">
    {{ str_limit($project->description , 100 , '') }}
  </div>

  <footer>
    <form method="POST" action="{{ $project->path() }}" class="text-right">
      @method('DELETE')
      @csrf
      <button type="submit" class="text-xs">Delete</button>
    </form>
  </footer>
</div>
