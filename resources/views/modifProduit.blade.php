@include('layout.header')

<div><a href="{{ route('listeP') }}" class="lien-color">retour</a></div>


<form action="{{ url('modifProduit') }}" method="POST" enctype="multipart/form-data">
   
{{ csrf_field() }}
{!! method_field('PUT') !!}
<input type="hidden" name="id" value="{{ $produitModif->id }}">
<div class="form-group">
    <label>Article : </label>
    <div>
        <input type ='text' value='{{$produitModif->titre}}' name="titre"></input><br>
            @if($produitModif->img)
            <img src="{{ asset('storage/image/'.$produitModif->img) }}"><br>
            @endif
            <input type="hidden" name="img2" value="{{$produitModif->img}}">
            <input type="file" name="img"><br>
            <input type ='text' value='{{$produitModif->message}}' name="message"></input><br>
    </div>
</div>
<div>
    <div >
        <input type="submit" name="modif" value="Modifier">
    </div>
</div>
</form>

@include('layout.footer')