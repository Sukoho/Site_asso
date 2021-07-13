@include('layout.header')

    <div class="div-back"><a href="{{url('/')}}" class="div-back-btn">&times;</a></div>

    <h1 class="noAllEvent"> Tous les Events  :</h1>
    
    @forelse ( $allEvent as $events )
    
        <div class="article">
            
            <img src="{{ asset('storage/image/'.$events->img) }}" class="cadreImage2">
            <h1 class="titreArticle">{{$events->titre}}</h1>

            <h1 class="message">{{$events->message}}</h1>
            <br>
            <h3 >{{$events->date}}</h3>

        </div>
    @empty
        <h1 class="noAllEvent">Il n'y a pas d'Evénement</h1>
    @endforelse 

@include('layout.footer')