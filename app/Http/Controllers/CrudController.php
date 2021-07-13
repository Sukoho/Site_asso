<?php

namespace App\Http\Controllers;

use App\Http\Requests\AutosuppRequest;
use App\Http\Requests\requestAjoutEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Calendars;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\Type\ObjectType;


class CrudController extends Controller
{
    /**
     * [Contrôle que l'utilisateur doit être connecté pour accéder à certaines pages]
     */
    public function __construct(){
        $this->middleware('auth')->except(['afficherTous','listeEvent','autoSuppression','deadEvent','listedate']);
    }

    /**
     * [Liste de tous les articles]
     * @return [view] [Passe en paramètre la requête]
     */
    public function afficherTous(){
        $allEvent = Calendars::orderBy("date", "ASC")->get();
        return view('allEvent',['allEvent' => $allEvent]);
    }
    
    /**
     * [Ajoute un event]
     * @param  Request $request [Récupère les des données du formulaire]
     * @return [view]           [Affiche une nouvel page du calendrier modifier]
     */
    public function ajouterEvent(Request $request){
        // Vérifie les conditions de l'objet
        $validator = Validator::make($request->all(), [
            'date' => 'required|date_format:"Y-m-d"',
            'titre' => 'required|unique:calendars|max:255',
            'message' => 'required|unique:calendars',
            'img' => 'image|mimes:jpg,png,jpeg,gif|max:50000|dimensions:min_width=100,min_height=100,max_width=10000,max_height=10000',
            ]);
            
            // En cas d'erreurs, il redirige vers la page d'accueil
        if($validator->fails()){
            // $validator->fails();
            return redirect('/')->withInput($request->all())->withErrors($validator);
        };
        // Vérifie s'il y a un fichier
        if ($request->hasFile('img')) {
            
            // Récupère le nom de l'image plus le temps pour que l'image soit unique lors de la sauvegarde
            $image = time().$_FILES['img']['name'];
            
            // Sauvegarder une image
            $request->file('img')->storePubliclyAs('public/image/', $image);
        }else{
            $image = "logo.jpg";
            }
            // Création d'une instance
            $event = new Calendars();   
                // Assignation des attributs
                $event->date = $request->date;
                $event->titre = $request->titre;
                $event->img = $image;
                $event->message = $request->message;
                // Assignation des attributs                
                $event->save();
                $date =  $event->date;
                // Envoie un mail à chaque personne abonnée lors d'un ajout d'event
                 FormulaireController::news($date);
                $event=CrudController::listeEvent($event->date);
                return view('textFormDay',['fecha'=>$event->date,'event' => $event]);
    }
    
    /**
     * [Récupère toutes les données d'un event pour les modifier]
     * @param  Request $request [Récupère les données]
     * @return [view]           [Passe en paramètre les données d'un event dans un nouvel objet pour le modifier]
     */
    public function edit(Request $request){
        $id = $request->id;
        $fecha = $request->date;
        
        // Récupération d'un tuple (=entrée) avec l'ID dans une BDD 
        $modif = new Calendars();
        $modif->date = Calendars::where('id','=',"$id")->value('date'); 
        $modif->titre = Calendars::where('id','=',"$id")->value('titre'); 
        $modif->img = Calendars::where('id','=',"$id")->value('img'); 
        $modif->message = Calendars::where('id','=',"$id")->value('message'); 
        $modif->id = Calendars::where('id','=',"$id")->value('id'); 
        
        // Redirige vers la view avec un paramètre
        return view('modifEvent', ["modif" => $modif,"fecha" => $fecha]);
    }
    
    /**
     * [Permet de modifier les données d'un event]
     * @param  Request $request [Récupère les données du nouvel event modifié]
     * @return [view]           [Redirige à la même page avec la modification]
     */
    public function modifierEvent(Request $request){
        $validator = Validator::make($request->all(), [
            'newDate' => '|date_format:"Y-m-d"',
            'newTitre' => '|max:255',
            'newMessage' => '',
            'newImg' => 'image|mimes:jpg,png,jpeg,gif|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
            ]);
            // En cas d'erreurs, il redirige vers la page d'accueil
            if($validator->fails()){
                return redirect('/modifEvent')->withInput($request->except('key'))
                ->withErrors($validator);
            }
            // Récupération d'un tuple (=entrée) avec l'ID dans une BDD 
            $event = Calendars::find($request->id);
            // Vérifie s'il y a un fichier
            if ($request->hasFile('newImg')) {
                
                $event->img = $request->actualImg;
                // Suppression de l'ancienne image dans le dossier image
                Storage::delete('public/image/'.$event->img);
                
                // Récupère le nom de l'image plus le temps pour que l'image soit unique lors de la sauvegarde
                $image = time().$_FILES['newImg']['name'];
                
                // Sauvegarder une image
                $request->file('newImg')->storePubliclyAs('public/image/', $image);
                $event->img = $image;
            
            }else{
                // Récupération du nom de l'image non modifier
                $event->img = $request->actualImg;
            }
            // Assignation des attributs
            $event->date = $request->newDate;
            $event->titre = $request->newTitre; 
            $event->message = $request->newMessage;
            $event->save();
            
            $event=CrudController::listeEvent($event->date);
            return view('textFormDay',['fecha'=>$event->date,'event' => $event]);
            // Redirige vers le form
        }
        
        /**
         * [Supprime automatiquement tous les events passés à la date du jour]
         * @param  AutosuppRequest $request [Récupère les données contrôlées]
         * @return [view]                   [Dirige vers la page CRUD d'event]
         */
        public static function autoSuppression(AutosuppRequest $request){
            $fecha=$request->date;
            $realDate=$request->realdate;
            $deadEvent=CrudController::deadEvent($realDate);
            $event=CrudController::listeEvent($fecha);
            return view('textFormDay',['deadEvent'=>$deadEvent,'fecha'=>$fecha,'event' => $event]);    
        }

        /**
         * [Fonction de destruction automatique d'event antérieur à la date passée en paramètre]
         * @param  [Date] $fecha [date du jour]
         */
        public static function deadEvent($fecha){
            $compteur= Calendars::where('date','<',"$fecha")->count('id');
            for ($i=0; $i < $compteur; $i++) { 
                $id = Calendars::where('date','<',"$fecha")->value('id');
                $img = Calendars::where('date','<',"$fecha")->value('img');
                Calendars::where('id','=',"$id")->delete();
            if(img != "logo.jpg"){
                Storage::delete('public/image/'.$img);
            }
            }
        }

        /**
         * [Fonction de suppresion d'event]
         * @param  Request $request [Doonées d'un event]
         * @return [view]           [Redirige à la même page après la supression de l'event]
         */
        public function supprimerEvent(Request $request){
            $event = $request->id;
            $img = $request->img;
            $fecha=$request->date;

            if($request->img != "logo.jpg"){
            // Suppression l'image dans le dossier image
            Storage::delete('public/image/'.$img);
            }
            // Requête SQL DELETE
            Calendars::where('id',  $event)->delete();
            // Redirige vers l'accueil
            $event=CrudController::listeEvent($fecha);
            return view('textFormDay',['fecha'=>$fecha,'event' => $event]);
        }
        
    
        /**
         * [Fonction pour récupérer tous les event d'une date]
         * @param  [variable] $fecha [Récupère une date]
         * @return [variable]        [tous les events]
         */
        public static function listeEvent($fecha){
            //fonction de récup d'event en base de donnée 
            $event = new Calendars();
            $event->test = Calendars::orderBy("created_at", "desc")->get(); // fonction pour savoir ce qui a dans la bdd
            $event->all = Calendars::orderBy("created_at", "desc")->where('date',"$fecha")->get();
            $event->date = Calendars::orderBy("created_at", "desc")->where('date',"$fecha")->value('date');
            $event->id = Calendars::orderBy("created_at", "desc")->where('date',"$fecha")->value('id');
            $event->titre = Calendars::orderBy("created_at", "desc")->where('date',"$fecha")->value('titre');
            $event->img = Calendars::orderBy("created_at", "desc")->where('date',"$fecha")->value('img');
            $event->message = Calendars::orderBy("created_at", "desc")->where('date',"$fecha")->value('message');
            return $event;
        }

        /**
         * [Fonction qui rend cliquable les jours du mois égal ou après la date]
         * @param  [variable] $mois [Mois en cours]
         * @param  [variable] $year [Année en cours]
         * @return [variable]       [Tableau des dates]
         */
        public static function listedate($mois,$year){
            $nbJoursDuMois=date("t",mktime(1,1,1,intval($mois),1,intval($year)));

            for($jour = 1; $jour <= $nbJoursDuMois; $jour++){
                $eventDate=date("Y-m-d",mktime(1,1,1,$mois,$jour,$year));
                $eventa = new Calendars();
                $eventa->date = Calendars::orderBy("created_at", "desc")->where('date',"$eventDate")->value('date');
                if ($eventa->date !== null) {
                    $format = explode("-", $eventa->date);
                    $day = $format[2]; 
                    $tab[] = $day;
/*                    return '<br>';
 */                }
                
            }
            if (!empty($tab)) {
                return $tab;
            }
            
        }
}

