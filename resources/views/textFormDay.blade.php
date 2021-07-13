@include('layout.header')

    <div class="div-back"><a href="{{url('/')}}" class="div-back-btn">&times;</a></div>
    
    <h1 class="event-date">Events du {{$fecha}} :</h1>
   
    @auth
     <fieldset>
        <legend class="add-Event">Créer un event </legend>
            <form method="post" action="{{route("creation")}}" enctype="multipart/form-data">
                @csrf
                <div class="article">
                <input type="hidden" name="date" value="{{$fecha}}">
                <label for="titre">Titre de l'event : </label><input type="text" id="titre" name="titre" class="titreArticle"  >
                <input type="file" name="img" class="cadreImage2">
                <label for="message">Message : </label><textarea type="text" name="message" class="message"></textarea>
                <input type="submit" name="send" value="Valider">
                <input type="reset">
                </div>
            </form>
    </fieldset>
    @endauth
    
    @forelse ( $event->all as $events )
    
        <div class="article">
        
        <a href="{{url('/')}}" class="btn-retour lien-color">retour</a>
        <h1 class="titreArticle">{{$events->titre}}</h1>
        <img src="{{ asset('storage/image/'.$events->img) }}" class="cadreImage2">
        <h1 class="message">{{$events->message}}</h1>
            @auth
        <form method="post" action="{{url("supprimer")}}">
            @csrf
            {{method_field('DELETE')}}
            <input type="hidden" name="date" value="{{$fecha}}">
            <input type="hidden" name="img" value="{{$events->img}}">
            <input type="hidden" name="id" value="{{$events->id}}">
            <input type="submit" name="send" value="supprimer">
        </form>
        <form method="post" action="{{url("modifier")}}">
            @csrf
            {{method_field('PUT')}}
            <input type="hidden" name="date" value="{{$fecha}}">
            <input type="hidden" name="id" value="{{$events->id}}">
            <input type="submit" name="send" value="modifier">
        </form>
        @endauth
        </div>
    @empty
        <h1 class="noAllEvent">Il n'y a pas d'Event le {{$fecha}}</h1>
    @endforelse 

@include('layout.footer')