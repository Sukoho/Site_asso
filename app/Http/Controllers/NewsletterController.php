<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NewsletterRequest;
use App\Http\Requests\DesaboRequest;
use App\Http\Controllers\Controller;
use Illuminate\View\ViewName;
use App\Models\Newsletter;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{   
    /**
     * [Dirige vers le formulaire de la newsletter]
     * @return [view] [vue de la newsletter]
     */
    public function create()
    {
        return view('newsletter');
    }
    /**
     * [Enregistre l'abonnement dans la BDD]
     * @param  NewsletterRequest $request [Récupère les données contrôlées parla Request]
     * @return [view]                     [Dirige vers la vue de confirmation]
     */
    public function store(NewsletterRequest $request)
    {
        // Regex pour ne pas accepter les caractères spéciaux dans l'email
        $request->validate([
        'email' => 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'
        ]);
        
        $newsletter = new Newsletter();

        $newsletter->name = $request->name;
        $newsletter->email = $request->email;
        $newsletter->save(); 

        return view('confirm');
    }
    /**
     * [Dirige vers le formulaire de desabonnement]
     * @return [view] [vue de desabonnement]
     */
    public function desabonner(){
        return view('desabonner');
    }
        /**
     * [Permet de supprimer son abonnement dans la base de donnée]
     * @return [view] [Dirige vers la vue de confirmation]
     */
    public function desabo(DesaboRequest $request)
    {
        $newsletter=Newsletter::where('email','=',$request->email)->delete();
        return view('desaboConfirm');
    }
}
