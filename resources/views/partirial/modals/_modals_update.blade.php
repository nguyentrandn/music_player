<!-- Modal Update-->

<div class="modal fade" id="modal_update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal Update</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" >
            <form action="{{ route('song.edit_song') }}" method="POST" enctype="multipart/form-data">
                @csrf
            <div id="show_view_song"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Create</button>
        </div>
      </form>
      </div>
    </div>
  </div>
  {{-- end modals--}}
