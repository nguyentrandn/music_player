@if (isset($song))
    <input type="hidden" name="id" value="{{$song->id}}">
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" value="{{ $song->name }}">
    </div>
    <div class="mb-3">
        <label for="author" class="form-label">Name author</label>
        <input type="text" class="form-control" id="author" name="author" aria-describedby="emailHelp" value="{{ $song->author }}">
      </div>
    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">Song file</label>
      <input type="file" name="song" class="form-control">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Image file</label>
        <input type="file" name="image" class="form-control">
      </div>
</div>
@endif