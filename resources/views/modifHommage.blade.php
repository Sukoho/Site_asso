@include('layout.header')

<div class="background-hommage">

<form action="{{ url('modifHommage') }}" method="POST" enctype="multipart/form-data">

{{ csrf_field() }}
{!! method_field('PUT') !!}
<input type="hidden" name="id" value="{{ $hommageModif->id }}">
    <h1 class="titre-hommage">Hommage</h1>
    <div class="pc-hommage">
        <div>
        @error('titre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <input type ='text' value='{{$hommageModif->titre}}' name="titre" class="titre-hommage"></input>
        @error('message')
                <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        </div><br>
        @error('img')
                <div class="invalid-feedback">{{ $message }}</div>
        @enderror
            <img src="{{ asset('storage/image/'.$hommageModif->img) }}" class="img-hommage"><br>
            <input type="hidden" name="img2" value="{{$hommageModif->img}}"/>
            <input type="file" name="img"/><br>
            <textarea type="text" name="message" class="message-hommage">{{$hommageModif->message}}</textarea>
            <br>
        <div><input type="submit" name="modif" value="Modifier"></div>
        <div><a href="{{ route('listeH') }}" class="lien-color">retour</a></div>

    </div>
</form>
</div>