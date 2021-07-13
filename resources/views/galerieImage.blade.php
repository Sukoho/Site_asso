@include('layout.header')


	@auth
	<div class="background-produit">
	<div class="div-back"><a href="{{url('/')}}" class="div-back-btn">&times;</a></div>

	<h1>Ajouter un produit</h1>

		<form method="post" action="{{url("addProduit")}}" enctype="multipart/form-data">
	<div>
		{{csrf_field()}}
		<span ><div><label for="titre">Titre du produit : </label></div>
			@error('titre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <input type="text" id="titre" name="titre" value="{{ old('titre') }}"></span>
            @error('img')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
		<span><input type="file" name="img"></span>
		<span><div><label for="message">Message : </label></div>
			@error('message')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
			<textarea type="text" name="message" cols="70" rows="20" >{{ old('message') }}</textarea></span>
		<input type="submit" name="send" value="Valider">
		<input type="reset">
	</div>
	</form>

	<div id="grid-container-produit">
		@foreach($produits as $produit)
			<div class="positionTitreProduit">
				<a href="{{url('produits/'.$produit->id)}}"><img src="{{ asset('storage/image/'.$produit->img) }}" class="cadreProduit">
						<h2 class="flex-container">{{$produit->titre}}</h2>
				</a>
				<form action="{{url('produits/'.$produit->id)}}" method="post">
				{{csrf_field()}}
				{!!method_field('DELETE')!!}
		
			<input type="hidden" name="id" value="{{$produit->id}}">
<button>Supprimer</button>
			</form>
			<form action="{{ url('modifProduits/'.$produit->id) }}" method="GET">
            <div><button>
                Modifier
            </button></div>			
        </form>
			</div>
			

		@endforeach
	</div>
	</div>
	@endauth

	@guest

	<div class="background-produit">

	<div class="div-back"><a href="{{url('/')}}" class="div-back-btn">&times;</a></div>

	<h1 class="h1-produit">Produit & Prestation</h1>

	<div id="grid-container-produit">
		@foreach($produits as $produit)
			<div class="positionTitreProduit">
				<a href="{{url('produits/'.$produit->id)}}">
					<img src="{{ asset('storage/image/'.$produit->img) }}" class="cadreProduit">
					<h2 class="flex-container-produit">{{$produit->titre}}</h2>
				</a>
			</div>
		@endforeach
	</div>
	</div>
	@endguest

@include('layout.footer')