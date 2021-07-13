<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;
use Illuminate\View\ViewName;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;
use App\Mail\Newsletter;
use Illuminate\Support\Facades\DB;

class FormulaireController extends Controller
{
    /**
     * [Contrôle que l'utilisateur doit être connecté pour accéder à certaines pages]
     */
    public function __construct(){
        $this->middleware('auth')->except(['create','store']);
    }
    /**
     * [Dirige à la vue du formulaire]
     * @return [view] [Formulaire]
     */
    public function create()
    {
        return view('formulaire');
    }
    /**
     * [Envoie un mail à chaque nouvel event, seulement pour les abonnées]
     * @param  [variable] $var [Récupère la date de l'event]
     */
    public static function news($var)
    {
        $tab[] = $var;
        $sendNewsletter = DB::table('Newsletter')->select('email')->get();
        Mail::to($sendNewsletter)
        ->send(new Newsletter($tab)); 
    }
    /**
     * [Enregistre un nouvel abonné pour la newsletter]
     * @param  ContactRequest $request [Récupère les données contrôlées de la newsletter]
     * @return [view]                  [Vue de confirmation d'enregistrement]
     */
    public  function store(ContactRequest $request)
    {
        $request->validate([
        'email' => 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'
        ]);
        Mail::to('mikiomenard4@gmail.com')
        ->send(new Contact($request->except('_token')));

        return view('confirm');
    }
}
