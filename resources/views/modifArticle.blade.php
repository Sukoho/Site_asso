@include('layout.header')

<form action="{{ url('modifArticle') }}" method="POST" enctype="multipart/form-data">
   
{{ csrf_field() }}
{!! method_field('PUT') !!}
<input type="hidden" name="id" value="{{ $articleModif->id }}">
    <h1 class="h1-article">Article</h1>
    <div class="article">
        <input type ='text' value='{{$articleModif->titre}}' name="titre" class="titreArticle"></input><br>
            @if($articleModif->img)
            <img src="{{ asset('storage/image/'.$articleModif->img) }}" class="cadreImage2"><br>
            @endif
            <input type="hidden" name="img2" value="{{$articleModif->img}}">
            <input type="file" name="img"><br>
            <textarea type="text" name="message" class="message">{{$articleModif->message}}</textarea><br>
        <div><input type="submit" name="modif" value="Modifier"></div>
        <div><a href="{{ route('add') }}" class="lien-color">retour</a></div>

    </div>
</form>
@include('layout.footer')
