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
                        <ul>
                            
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
                    <div class=" btn-play bt">
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
    <link rel="stylesheet" href="{{ asset('js/index.js') }}">
    <script>
        var audio = $('#audio');
        var image = $('.img_backgound');
        var btnPlay =  $('#player');

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

            // play song
           $('.btn-play').click(function(){
                checkPlay();
            })
            // next song
            $('.btn-next').click(function(){
                ++page;
                playSong()
                btnPlay.attr('name', 'pause')

            })
            // previous song
            $('.btn-prev').click(function(){
                --page;
                playSong()
                btnPlay.attr('name', 'pause')
            })
        });
        // check play song
        function checkPlay() {
            if ($('#audio')[0].paused) {
                btnPlay.attr('name', 'pause')
                $('#audio')[0].play();
            }else{
                btnPlay.attr('name', 'play-circle')
                $('#audio')[0].pause();
            }
        }

        // get the song data
        var page = 1;
        var getUrl = window.location;
        var total = 0;
        // get the song
        function playSong() {
            $.ajax({
                url: '{{ route('user.getSong') }}' + '?page=' + page,
            })
            .done(function(reponse) {
                const data = reponse.data[0];
                if (data) {
                    audio.attr('src', `${getUrl.protocol}//${getUrl.host}/storage/songs/${data.song_name}`);
                    image.css('backgroundImage', 'url(' + `${getUrl.protocol}//${getUrl.host}/storage/images/${data.image}` +')' );
                    $('.music-name').text(data.name + ' - ' + data.author);
                }
                //validate next or previous
                switch (page) {
                    case 0:
                        page = reponse.total
                        playSong();
                        break;
                    case reponse.total + 1:
                        page = 1;
                        console.log(page);
                        playSong();
                        break;
                    default:
                        break;
                }
            })
        }
        playSong();

    </script>
    </body>
</html>
