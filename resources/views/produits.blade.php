@include('layout.header')

				<div class="article">
				
				<img src="{{ asset('storage/image/'.$produits->img) }}" class="cadreImage2">
				<div><a href="{{ URL::previous() }}" class="lien-color">retour</a></div>
				
				<div class="titreArticle">{{$produits->titre}}</div>
				<div class="message">{{$produits->message}}</div>
				</div>

@include('layout.footer')
