<body id="Jordan">
    <nav class='nav'>
       
       <div class="header_logo ">
           <img src="{{asset('storage/image/trans.PNG')}}" class='header_img_logo' width="70px" height="70px" alt="logo">
       </div>
       
       <div class="header_link">
           <div class=" navbar ">
               <div class="  dropdown ">
                   <span class="dropbtn">Histoire 
                     <i class="fa fa-caret-down"></i>
                   </span>
                   <div class="dropdown-content">
                     <a href="{{url("bio")}}">Bio</a>
                     <a href="{{route('listeH')}}">Hommages</a>
                   </div>
                 </div> 
           </div>
           <div class="header_nav ">
               <a href="#show" class="header_cadre">Article</a>
           </div>
           <div class="header_nav ">
               <a href="{{route('listeP')}}" class="header_cadre">Prestation</a>
           </div>
           <div class=" header_nav ">
                 <a href="{{url('allEvent')}}" class="header_cadre">Events</a>
                <div class="dropdownCalendar-content">
                    @if ($calendrier===true)
                        @include('calendrier')
                    @else
                        @include('nextCalendrier')
                    @endif 
                </div>
            </div> 
        </div>

       <div class="header_login">
           {{-- <div class="header_nav "> --}}
               @if (Route::has('login'))
               <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block ">
                   @auth
                   @else
                       <a href="{{ route('login') }}" class="header_cadre">Connexion</a>
                       
@if (Route::has('register'))
<a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline header_cadre">Register</a>
@endif
                   @endauth
               </div>
           @endif
           @auth
           <form method="POST" action="{{ route('logout') }}">
               @csrf
               <button type="submit" class="header_cadre btn-logging">
                   {{ __('Déconnecter') }}
               </button>
           </form>
           <button class="btn-logging "><a href="{{url('AddArticle')}}" class="btn-logging header_cadre">Ajouter un article</a></button>
           @endauth
           {{-- </div> --}}
       </div>
       

   <a href="javascript:void(0);" class="header_icon" onclick="openNav()" ><img src="{{asset('storage/image/menu.PNG')}}" width="50px" height="50px" alt="menu"></img></a>

   <div id="myNav" class="header_overlay">
       <a href="javascript:void(0)" class="header_closebtn" onclick="closeNav()">&times;</a>
       <div class="header_overlay-content">
            <a href="#show" class="header_cadre">Article</a>
            <a href="{{url('allEvent')}}">Events</a>
            <a href="{{route('listeP')}}">Prestation</a>
            <a href="{{url('newsletter')}}">Newsletter</a>
            <a href="{{url('formulaire')}}">Contact</a>
            <a href="{{url("bio")}}">Bio</a>
            <a href="{{route('listeH')}}">Hommages</a>
           @if (Route::has('login'))
               <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                   @auth
                   @else
                       <a href="{{ route('login') }}" class="header_cadre">Connexion</a>
                       
            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
            @endif
                   @endauth
               </div>
           @endif
           @auth
           <form method="POST" action="{{ route('logout') }}">
               @csrf
               <button type="submit" class="btn-logging">
                   {{ __('Déconnecter') }}
               </button>
           </form>
           <a href="{{url('AddArticle')}}" class="btn-logging ">Ajouter un article</a>
           @endauth
       </div> 
   </div>

</nav>  
<a href="{{url('formulaire')}}" class="Form_icon"  ><img src="{{asset('storage/image/letter.PNG')}}" width="60px" height="60px" alt="formulaire"></a>

<a href="{{url('newsletter')}}" class="Form_icon2"  ><img src="{{asset('storage/image/newsletter.PNG')}}" width="60px" height="60px" alt="newsletter"></a>
