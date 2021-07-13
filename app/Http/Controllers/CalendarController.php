<?php

namespace App\Http\Controllers; // pour désigné les chemins

use App\Models\Articles;
use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;
use App\Http\Requests\NextRequest;
use App\Http\Requests\PrevRequest;

class CalendarController extends Controller
{       
        /**
         * [Permet de créer un calendrier standard]
         * @return [variable]       [Récupère toutes les données pour construire un calendrier]
         */
        public static function buildCalendrier() {
        //création d'une fonction qui crée un objet dateTime 
        $calendrier = new \DateTime(); //le backslach permet d'utiliser la fonction php
        //ici j'enregistre la date actuel dans plusieur format 
        //affin de les ytiliser dans ma vue 
        $calendrier->date = $calendrier->format('Y-m-d');
        $calendrier->year = $calendrier->format('Y');
        $calendrier->month =$calendrier->format('m');
        $calendrier->day = $calendrier->format('d');
        return $calendrier;
    }

    /**
     * [Permet d'ajouter un mois à la date en cours et de l'afficher]
     * @param  NextRequest $request [Contrôle le format de la date]
     * @return [view]               [Affiche le calendrier après l'ajout]
     */
    public static function affichageCalendarNextMonth(NextRequest $request){
        $next=$request->next;
        $calendar=CalendarController::buildCalendrier();
        $varMois=CalendarController::buildMoisCalendrier();
        $newCalendrier=CalendarController::buildNextCalendrier($next);
        $mois=CalendarController::mois();
        $semaine=CalendarController::semaine();
        $nbJour=CalendarController::nombreJourMois($newCalendrier->newMonth,$newCalendrier->newYear);
        $premierJour=CalendarController::PremierJourDuMois($newCalendrier->newMonth,$newCalendrier->newYear);
        $nextEventa = CrudController::listedate($newCalendrier->newMonth,$newCalendrier->newYear);
        $articles = Articles::orderBy("created_at", "desc")->paginate(9); 
        $calendrier = false;
        return view('accueil', ['articles' => $articles,'nextEventa' => $nextEventa,'calendar' => $calendar,'varMois' => $varMois,'newDate' => $newCalendrier,'mois' => $mois,'semaine' => $semaine,'nbJour' => $nbJour,'premierJour' => $premierJour,'calendrier'=>$calendrier]);
    }

    /**
     * [Permet d'enlever un mois à la date en cours et de l'afficher]
     * @param  PrevRequest $request [Contrôle le format de la date]
     * @return [view]               [Affiche le calendrier après le changement]
     */
    public static function affichageCalendarPrevMonth(PrevRequest $request){
        $prev=$request->prev;
        
        $calendar=CalendarController::buildCalendrier();
        $varMois=CalendarController::buildMoisCalendrier();
        $newCalendrier=CalendarController::buildPrevCalendrier($prev);
        $mois=CalendarController::mois();
        $semaine=CalendarController::semaine();
        $nbJour=CalendarController::nombreJourMois($newCalendrier->newMonth,$newCalendrier->newYear);
        $premierJour=CalendarController::PremierJourDuMois($newCalendrier->newMonth,$newCalendrier->newYear);
        $prevEventa = CrudController::listedate($newCalendrier->newMonth,$newCalendrier->newYear);
        $articles = Articles::orderBy("created_at", "desc")->paginate(9); 
        $calendrier = false;
        return view('accueil', ['articles' => $articles,'nextEventa' => $prevEventa,'calendar' => $calendar,'varMois' => $varMois,'newDate' => $newCalendrier,'mois' => $mois,'semaine' => $semaine,'nbJour' => $nbJour,'premierJour' => $premierJour,'calendrier'=>$calendrier]);
    }
    
    /**
     * [buildMoisCalendrier description]
     * @return [variable] [Récupère le mois en cours]
     */
    public static function buildMoisCalendrier() {
        //création d'une fonction qui crée un objet dateime 
        $calendrier = new \DateTime(); //le backslach permet d'utiliser la fonction php
        //ici j'enregistre la date actuel dans plusieur format 
        //affin de les ytiliser dans ma vue 
        $leMois =$calendrier->format('m');
        return $leMois;
    }
    
    /**
     * [Fonction va prendre en parametre une date afin de lui ajouter un mois]
     * @param  [date] $post [date au moment de la modification]
     * @return [variable]       [Objet du nouveau calendrier après ajout]
     */
    public static function buildNextCalendrier($post) {
        $newCalendrier = new \Datetime($post); 
        //fonction qui ajoute 1mois
        $newCalendrier->add(new \DateInterval('P1M'));
        $newCalendrier->newDate = $newCalendrier->format('Y-m-d');
        $newCalendrier->newYear = $newCalendrier->format('Y');
        $newCalendrier->newMonth =$newCalendrier->format('m');
        $newCalendrier->newDay = $newCalendrier->format('d');
        return $newCalendrier;
    }

    /**
     * [Fonction va prendre en parametre une date afin de lui enlever un mois]
     * @param  [date] $post [date au moment de la modification]
     * @return [type]       [Objet du nouveau calendrier après retrait]
     */
    public static function buildPrevCalendrier($post) {

        $newCalendrier = new \Datetime($post);  
        //fonction qui retire 1mois
        $newCalendrier->sub(new \DateInterval('P1M')); 
        $newCalendrier->newDate = $newCalendrier->format('Y-m-d');
        $newCalendrier->newYear = $newCalendrier->format('Y');
        $newCalendrier->newMonth =$newCalendrier->format('m');
        $newCalendrier->newDay = $newCalendrier->format('d');
        return $newCalendrier;

    }

    /**
     * [Fonction qui permet d'obtenir le nombre de jour d'un mois à partir d'un mois et d'une année passé en paramètre]
     * @param  [variable] $month [Mois en cours]
     * @param  [variable] $year  [Année en cours]
     * @return [variable]        [Récupère le nombre de jours en fonction du mois]
     */
    public static function nombreJourMois($month,$year) {
        $NbrDeJour=date("t",mktime(1,1,1,intval($month),1,intval($year)));
        return $NbrDeJour;
    }
    
    /**
     * [Fonction qui permet d'obtenir le premier jour d'un mois à partir d'un mois et d'une année passé en paramètre]
     * @param [variable] $month [Mois en cours]
     * @param [variable] $year  [Année en cours]
     * @return [variable]       [Détermine le premier jour en fonction du mois]
     */
    public static function PremierJourDuMois($month,$year) {
        $premierJour=date("w",mktime(1,1,1,intval($month),1,intval($year)));
        return $premierJour;
    }

    /**
     * [Liste de tous les mois]
     * @return [variable]       [Liste de tous les mois]
     */
    public static function Mois() {
        $mois = array(1=>"Janvier",2=>"Février",3=>"Mars",4=>"Avril",5=>"Mai",6=>"Juin",7=>"Juillet",8=>"Août",9=>"Septembre",10=>"Octobre",11=>"Novembre",12=>"Décembre");
        return $mois;
    }

    /**
     * [Liste de tous les jours de la semaine]
     * @return [variable]       [Liste de tous les jours de la semaine]
     */         
    public static function semaine() {
        $jours = array(1=>"Lu",2=>"Ma",3=>"Me",4=>"Je",5=>"Ve",6=>"Sa",7=>"Di",8=>"Lu",9=>"Ma",10=>"Me",11=>"Je",12=>"Ve",13=>"Sa",0=>"Di");
        return $jours;
    }

    
}
