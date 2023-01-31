@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Song Create</div>
                <div class="card-body">
                    <!-- Button trigger modal -->
                    <button type="button" id="btns" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
                      Create a new Song
                    </button>
                    <!-- Modal Create-->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form action="{{ route('songs.store') }}" method="POST" enctype="multipart/form-data">
                              @csrf
                              <div class="mb-3">
                                <label for="name" class="form-label">Name song</label>
                                <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp">
                              </div>
                              <div class="mb-3">
                                  <label for="author" class="form-label">Name author</label>
                                  <input type="text" class="form-control" id="author" name="author" aria-describedby="emailHelp">
                                </div>
                              <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Song file</label>
                                <input type="file" name="song" class="form-control">
                              </div>
                              <div class="mb-3">
                                  <label for="exampleInputPassword1" class="form-label">Category</label>
                                  <select class="form-select" name="category" aria-label="Default select example">
                                      @foreach($categorys as $category)
                                          <option value="{{ $category->id }}">{{ $category->name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                              <div class="mb-3">
                                  <label for="exampleInputPassword1" class="form-label">Image file</label>
                                  <input type="file" name="image" class="form-control">
                                </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                          </div>
                        </form>
                        </div>
                      </div>
                    </div>
                    {{-- end modals--}}
                  {{-- table --}}
                  <table id="table_id" class="display">
                    <thead>
                        <tr>
                          <th>Name</th>
                          <th>Author</th>
                          <th>Song Name</th>
                          <th>Category</th>
                          <th>Image</th>
                          <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
                  {{-- end table --}}
                  <!-- Modal review-->
                  <div class="modal fade" id="modalReview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Preview Song</h5>
                          <button type="button" class="btn-close close_modals" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <audio src="" id="audio" hidden></audio>
                          <div class="row mb-3">
                            <div class="col-md-5">
                              <img id="img_review" src="{{ url('storage/images/image_1673521443.png') }}" alt="img" srcset="" width="150px">
                            </div>
                            <div class="col-md-7">
                              <div class="col-12">
                                  <h3 class="show_name">Name</h3>
                                  <p class="show_author">Author</p>
                              </div>
                              <div class="col-12">
                                <span id="tracktime">0/0</span>
                                <input type="range" name="range" id="range">
                              </div>
                              <div class="col-12">
                                <button id="stop" >stop</button>
                                <button id="play">play</button>
                                <input type="range" id="slider" min="0" max="1" step="0.1">
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                        </div>
                      </form>
                      </div>
                    </div>
                  </div>
                  {{-- end modals--}}
                </div>
            </div>
        </div>
    </div>
</div>
@include('partirial.modals._modals_update')

@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script>

  var setIntervalGetTime
  var audio 

  $(document).ready( function () {
    let table = new DataTable('#table_id', {
      "processing": true,
        "serverSide": true,
        "bPaginate": true,
      ajax: {
          url: "{!! route('songs.index') !!}",
          type: 'GET',
      },
      columns: [
        {
            data: 'name',
            name: 'name'
        },
        {
            data: 'author',
            name: 'author'
        },
        
        {
            data: 'song_name',
            name: 'song_name'
        },
        {
            data: 'category_id',
            name: 'category_id'
        },
        {
            data: 'image',
            name: 'image'
        },
        {
            data: 'action',
            name: 'action'
        },
      ],
    });

    $(document).on('click', '#show_review', function(){
      var id = $(this).data('id');

      $.ajax({
        url: "{{ route('getSong') }}",
        type: 'GET',
        data: {id}
      })
      .done((data) => {
        var song = data[0];
        var getUrl = window.location;
        $('#audio').attr('src', `${getUrl.protocol}//${getUrl.host}/storage/songs/${song.song_name}` );
        $('#img_review').attr('src', `${getUrl.protocol}/storage/images/${song.image}` );
        $('.show_name').text(song.name);
        $('.show_author').text(song.author);
        $('.category').text(song.category);
        $('#audio')[0].play();
        
        audio = $('#audio')[0];
        // bat dau dem thoi gian bai hat 
        setIntervalGetTime =  setInterval(() => {
          updateTime()
        }, 1000);
        
        
      })
    })

    // close modal
    $('.close_modals').on('click', function(){
      audio.pause();
      clearInterval(setIntervalGetTime); // xoa dem khi dong modal
    })

    // stop song
    $('#stop').click(function(){
      audio.pause();
      clearInterval(setIntervalGetTime); // xoa dem khi dong modal
    })

    // start song
    $('#play').click(function(){
      audio.play();
      setIntervalGetTime =  setInterval(() => {
          updateTime()
        }, 1000);
    })

    // thanh tien trinh 
    $('#range').on('change', function(){
      console.log(112);
      audio.currentTime = this.value;
    })  

    // volume
    $("#slider").on('change', function(){
      audio.volume = this.value;
    })
    
    // delete song
    $(document).on('click', '#delete_song',function(){
      console.log($(this).data('id'));
      data= {
        id: $(this).data('id'),
      }
      $.ajax({
        url: '{{ route('song.delete') }}',
        data: data,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
      })
      .done(function(){
        table.draw();
      })
    });

    // show update song
    $(document).on('click', '#show_update_song', function name(params) {
      $('#show_view_song').html('');
      data = {
        id: $(this).data('id'),
      }
      $.ajax({
        url: '{{ route('song.show_song')}}',
        data: data,
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
      })
      .done(function (data) {
        $('#show_view_song').append(data.html);
      })
    })
  });


  function updateTime() {
    var currTime = Math.floor(audio.currentTime).toString(); //thoi gian chay dc 
    var duration = Math.floor(audio.duration).toString(); // tong thoi gian

    $('#range').val(audio.currentTime);
    $('#range').attr('max', audio.duration);
    $('#tracktime').text(currTime + '/' + duration);
  }
  
</script>