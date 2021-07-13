@include('layout.header')

  <body>
    <h2>Un nouvel évenement a été ajouté pour la date du {{ $newsletter['0'] }}</h2>
    <ul>
      <li><strong>Venez dès maintenant le consulter : <a href="http://localhost:81/Laravel_Nadia_Alpha/public/allEvent">Voir ici</a></strong></li>
      <li><strong>Vous pouvez voir le <a href="http://localhost:81/Laravel_Nadia_Alpha/public">Site ici</a></strong></li>
    </ul>
    <h4><a href="http://localhost:81/Laravel_Nadia_Alpha/public/desabonnement">Se désabonner !!!</a></h4>
    
@include('layout.footer')                   
