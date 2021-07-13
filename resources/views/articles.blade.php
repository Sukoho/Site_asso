@include('layout.header')

				<body>
				<div class="article">
				<img src="{{ asset('storage/image/'.$articles->img) }}" class="cadreImage2">
				<a href="{{url('/')}}" class="btn-retour lien-color">retour</a>
				<div class="titreArticle">{{$articles->titre}}</div>
				<div class="message">{!!nl2br($articles->message)!!}</div>
				</div>

				<div id="flex-container-btn-fb">
				<a href="https://www.facebook.com/%C3%80-Petits-Pas-Avec-Jordan-2213281632330661" class="voirFB lien-color" target="blank">Voir toutes les photos <img src="{{ asset('storage/image/logoFB.png') }}" class="btn-FB-sticky"></a>
				</div>

@include('layout.footer')