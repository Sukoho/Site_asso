@include('layout.header')

    <h1>modifier l'article du {{$modif->date}}</h1>
    <div class="article">
        <form method="post" action="{{url("modifEvent")}}" enctype="multipart/form-data">
            @csrf
                {!! method_field('PUT') !!}
            <fieldset>
            <legend>modifier la date </legend>
                
                <input type="date" name="newDate" value="{{$modif->date}}" class="titreArticle">
            </fieldset>
            <fieldset>
            <legend>modifier la titre </legend>

                <label for="titre">Titre de l'article : </label><input type="text"  name="newTitre" value="{{$modif->titre}}" class="titreArticle">
            </fieldset>

            <fieldset>
                <legend>modifier l'image</legend>
                
                <input type="hidden" name="actualImg" value="{{$modif->img}}">
                <img src={{ asset('storage/image/'.$modif->img) }}>
                <input type="file" name="newImg" class="fileColor"   class="cadreImage2">
            </fieldset>

            <fieldset>
            <legend>modifier la message </legend>

                <textarea type="textarea" name="newMessage" class="message">>{{$modif->message}}</textarea>
            </fieldset>

            <input type="hidden" name="id" value="{{ $modif->id }}">

                <input type="submit" name="send" value="Valider">
                <input type="reset">
        </form>
        
            <form action='{{ url('event') }} ' method='post' >
                @csrf
                <input type='hidden' name='date' value='{{$fecha}}'>
                <input  type='submit' value='retour' >
            </form>
    </div>
   
    @include('layout.footer')

