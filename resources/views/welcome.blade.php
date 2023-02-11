<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a528ec5920.js" crossorigin="anonymous"></script>
    <!-- icon -->
    <script src="https://cdn.lordicon.com/lusqsztk.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.js"></script>
    <!-- Styles -->

    <link rel="stylesheet" href="{{ asset('css/index.css') }}">

    </head>
    <body class="antialiased">
        {{-- <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div> --}}
        <div class="container-fluid px-1 box-body">
            <!-- -------------------------- -->
            <div class="head gx-5">
                <div class="btn-darkmode mt-3 ms-1 align-self-start">
                    <ion-icon name="moon"></ion-icon>
                </div>
                <div class=" col mt-3 img_backgound mx-2"></div>
                <div class=" menue mt-3 me-1 align-self-start">
                    <div id="btn-menue">
                        <ion-icon name="menu"></ion-icon>
                    </div>
                    <div class="overlay"></div>
                    <div class="menu-list">
                        <ul id="show_list_songs">
                           
                        </ul>
                    </div>
                </div>
            </div>
            <!-- -------------------------- -->
            <div class="control row justify-content-around">
                <audio src="" id="audio" hidden autoplay></audio>
                <!--  -->
                <div class="col col-md-2 col-sm-3 input-range align-self-center">
                    <input type="range" name="range" id="range" value="0" step="1" min="0" max="100">
                    <label for="" id="time">3:00</label>
                </div>
                <div class="col group-btn ">
                    <div class=" btn-prev bt">
                        <ion-icon name="arrow-dropleft"></ion-icon>
                    </div>
                    <div class=" btn-play bt" id="btn_play">
                        <ion-icon id="player" name="play-circle"></ion-icon>
                    </div>
                    <div class=" btn-next bt">
                        <ion-icon name="arrow-dropright"></ion-icon>
                    </div>
                </div>
                <div class="col col-md-2 music-name align-self-center">Party lore</div>
            </div>
    
            <div class="overlay"></div>
        </div>
    <script>
        const audio = $('#audio');
        var image = $('.img_backgound');
        var currentSong = 0;
        var listSongs = [];
        var getUrl = window.location;
        var btnPlay =  $('#player');
        let isPlay = false;

        // get list of songs
        function getSongList(){
            $.ajax({
                url: '{{ route('user.getList') }}',
            })
            .done(function(data){
                listSongs = data
                loadSong()
                displaySongList();

            })
        }
        getSongList()
        // ------------------------------------------
        $(document).ready(function() {
            $("#btn-menue").click(function() {
                $(".menu-list").toggleClass("menue-active");
                $(".overlay").toggleClass("overlay-active");
            })
            $(".overlay").click(function(e) {
                $(".menu-list").toggleClass("menue-active");
                $(".overlay").toggleClass("overlay-active");
            });
            $(".btn-darkmode").click(function() {
                $(this).toggleClass("btn-dark");
                $(".container-fluid").toggleClass("darkmode-active");
                $(".menu-list").toggleClass("menu-dark")
                $(".bt").toggleClass("btn-dark");
                $()
            })
            // btn play
            $(document).on('click', '#btn_play', function(){
                isPlay = true;
                checkPlay();
                
            })
            // stop song
            $(document).on('click', '.pause_btn',function(){
                isPlay = false;
                checkPlay();
                
            })
            // next song
            $(document).on('click','.btn-next',function(){
                currentSong++;
                isPlay = true;
                audio[0].currentTime = 10;
                checkNextPrev()
                loadSong();
                checkPlay();

            })
            // previous song
            $(document).on('click','.btn-prev',function(){
                currentSong--;
                isPlay = true;

                checkNextPrev()
                loadSong();
                checkPlay();
            })
            $(document).on('click','.song-item',function(){
                currentSong = $(this).data('index');
                loadSong();
                checkPlay();
            })


            // thanh Range
            audio[0].ontimeupdate = function() {
                if (audio[0].duration) {
                    // làm tròn theo %
                    const progressPercent = Math.floor(audio[0].currentTime / audio[0].duration * 100)
                    console.log(progressPercent);
                    $('#range').val(progressPercent)

                    $('#time').text(Math.floor(audio[0].duration / 60) + ":00")
                }
            }
            $(document).on('change','#range',function(e){
                audio.pause();
                const seekTime = audio[0].duration / 100 * e.target.value
                audio.currentTime = seekTime
                audio.play();
                console.log(seekTime, audio[0].currentTime, audio[0].duration);
            })

        })

        // load song
        function loadSong(){
            let song = listSongs[currentSong];
            audio.attr('src', `${getUrl.protocol}//${getUrl.host}/storage/songs/${song.song_name}`);
            image.css('backgroundImage', 'url(' + `${getUrl.protocol}//${getUrl.host}/storage/images/${song.image}` +')' );
            $('.music-name').text(song.name + ' - ' + song.author);
        }
        
        // check play 
        function checkPlay() {
            if (isPlay == true) {
                $('#audio')[0].play();
                btnPlay.attr('name', 'pause')
                $('.btn-play').toggleClass("pause_btn");

            }else{
                $('#audio')[0].pause();
                btnPlay.attr('name', 'play-circle');
                $(this).removeClass("pause_btn");
            }
        }
        // check next or previous
        function checkNextPrev() {
            if (currentSong < 0) {
                currentSong = listSongs.length -1;
            } else if (currentSong > listSongs.length -1) {
                currentSong = 0;
            }
        }
        // display list of songs
        function displaySongList() {
            $("#show_list_songs").html('');
            const html = listSongs.map((song, index) => {
                return `
                    <li class="song-item justify-content-between ${index === currentSong ? 'song-active' : ""}" data-index="${index}"> 
                        <img src="${getUrl.protocol}//${getUrl.host}/storage/images/${song.image}" alt="" id="img" class="col col-1">
                        <label for="img"  class="col col-lg-8">${song.name + ' - ' + song.author}</label>
                        <div class="decription col-2"><ion-icon name="more"></ion-icon></div>
                    </li>
                `;
            })
            $("#show_list_songs").append(html);
        }
    </script>
    </body>
</html>
