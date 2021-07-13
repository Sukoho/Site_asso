@include('layout.header')

	<div class="div-back"><a href="{{url('/')}}" class="div-back-btn">&times;</a></div>

	<h1 class="h1-article">Liste d'articles</h1>

	<form method="post" action="{{url("articles")}}" enctype="multipart/form-data">

	<div class="article">
		{{csrf_field()}}					
		<span class="titreArticle">
			@error('titre')
				<div class="invalid-feedback">{{ $message }}</div>
			@enderror
			<div><label for="titre">Titre de l'article : </label></div>
			<input type="text" id="titre" name="titre" value="{{ old('titre') }}" class="champ"></span>
		<span class="cadreImage2"><input type="file" name="img"></span>
					
		<span class="message">
			@error('message')
				<div class="invalid-feedback">{{ $message }}</div>
			@enderror
			<div><label for="message">Message : </label></div><textarea id="message" type="text" name="message" cols="70" rows="20" class="champ">{{ old('message') }}</textarea></span>
		<input type="submit" name="send" value="Valider">
		<input type="reset">
	</div>
	</form>

	<table>
	@foreach ($articles as $article)
	<tr>
		<td>

			<form action="{{url('articles/'.$article->id)}}" method="post">
				{{csrf_field()}}
				{!!method_field('DELETE')!!}
				<div class="article">
					
				<input type="hidden" name="id" value="{{$article->id}}">
			<div class="titreArticle">{{$article->titre}}</div><br>
			@if($article->img)
			<img src="{{ asset('storage/image/'.$article->img) }}" class="cadreImage2"><br>
			@endif
			<div class="message">{!!nl2br($article->message)!!}</div><br>

			<button>Supprimer</button>
			</form>

			<form action="{{ url('articles/'.$article->id) }}" method="GET" class="form">
            <div><button>
                Modifier
            </button></div>

            
            </form>
            </div>
		</td>
	</tr>
	@endforeach
	</table>


