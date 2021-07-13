<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Hommage;
use App\Http\Requests\HommageRequest;
use App\Http\Requests\HommageModifRequest;
use Illuminate\Support\Facades\Storage;

class HommageController extends Controller
{
    /**
     * [Contrôle que l'utilisateur doit être connecté pour accéder à certaines pages]
     */
    public function __construct(){
        $this->middleware('auth')->except('listeHommage');
    }
    /**
     * [Liste de tous les articles]
     * @return [view] [Dirige vers la page des hommages]
     */
    public function listeHommage(){
        $hommages = Hommage::orderBy("created_at", "desc")->get(); 
        return view('hommage', ['hommages' => $hommages]);
    }

    /**
     * [Récupère les données d'un article en fonction de son ID pour être modifier]
     * @param  Articles $article [Appel de la classe]
     * @return [view]            [Redirige vers la view avec la nouvelle variable en paramètre]
     */
    public function editHommage(Hommage $hommage){
        // Récupération d'un tuple (=entrée) avec l'ID dans une BDD 
        $hommageModif = Hommage::find($hommage->id);
        // Redirige vers la view avec un paramètre
        return view('modifHommage', ["hommageModif" => $hommageModif]);
    }
    /**
     * [Enregistre un hommage dans la BDD]
     * @param  HommageRequest $request [Récupère les données contrôlées]
     * @return [Route]                  [Redirige vers une route]
     */
    public function ajouterHommage(HommageRequest $request){
        // Récupère le nom de l'image plus le temps pour que l'image soit unique lors de la sauvegarde
        $image = time().$_FILES['img']['name'];

        // Sauvegarder une image
        $request->file('img')->storePubliclyAs('public/image/', $image);

        // Création d'une instance
        $hommage = new Hommage();
        // Assignation des attributs
        $hommage->titre = $request->titre;
        $hommage->img = $image;
        $hommage->message = $request->message;
        // Requête INSERT INTO vers la BDD
        $hommage->save();

        // Redirige vers la page d'accueil
        return redirect()->route('listeH');
    }

    /**
     * [Supprimer l'hommage]
     * @param  Hommage $hommage [Appel de la classe]
     * @return [view]            [Redirection]
     */
    public function supprimerHommage(Hommage $hommage){
        
        // Suppression l'image dans le dossier image
        Storage::delete('public/image/'.$hommage->img);
        // Requête SQL DELETE
        $hommage->delete();
        // Redirige vers l'accueil
        return redirect()->route('listeH');
    }

        public function edit(Hommage $hommage){
        // Récupération d'un tuple (=entrée) avec l'ID dans une BDD 
        $hommageModif = Hommage::find($hommage->id);
        // Redirige vers la view avec un paramètre
        return view('modifHommage', ["hommageModif" => $hommageModif]);
    }

    /**
     * [Permet de modifier les détails d'un hommage]
     * @param  HommageModifRequest $request [Récupère les données contrôlées]
     * @return [view]           [retour à la page d'accueil après la modification de l'article dans la BDD]
     */
    public function modifierHommage(HommageModifRequest $request){

        // Récupération d'un tuple (=entrée) avec l'ID dans une BDD 
        $hommage = Hommage::find($request->id);
        
        // Vérifie s'il y a un fichier
        if ($request->hasFile('img')) {

            $hommage->img = $request->img2;
            // Suppression de l'ancienne image dans le dossier image
            Storage::delete('public/image/'.$hommage->img);

            // Récupère le nom de l'image plus le temps pour que l'image soit unique lors de la sauvegarde
            $image = time().$_FILES['img']['name'];

            // Sauvegarder une image
            $request->file('img')->storePubliclyAs('public/image/', $image);
            $hommage->img = $image;
        
        }else{
            // Récupération du nom de l'image non modifier
            $hommage->img = $request->img2;
        }
        // Assignation des attributs
        $hommage->titre = $request->titre;        
        $hommage->message = $request->message;
        $hommage->save();
        // Redirige vers l'accueil
        return redirect()->route('listeH');
    }
}