<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Http\Requests\ProduitRequest;
use App\Http\Requests\ProduitModifRequest;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except(['listeProduit','getProduit']);
    }
    /**
     * [Liste de tous les articles]
     * @return [type] [description]
     */
    public function listeProduit(){
        $produits = Produit::orderBy("created_at", "desc")->get(); 
        return view('galerieImage', ['produits' => $produits]);
    }
    /**
     * [Récupère toutes les données d'un produit pour l'afficher]
     * @param  Produit $produit [Récupère l'ID d'un produit]
     * @return [view]           [Dirige vers la vue de l'article en affichant ses détails]
     */
    public function getProduit(Produit $produit){
        $produits = Produit::find($produit->id);
        return view('produits', ['produits' => $produits]);
    }

    /**
     * [Récupère les données d'un article en fonction de son ID pour être modifier]
     * @param  Articles $article [Appel de la classe]
     * @return [view]            [Redirige vers la view avec la nouvelle variable en paramètre]
     */
    public function editProduit(Produit $produit){
        // Récupération d'un tuple (=entrée) avec l'ID dans une BDD 
        $produitModif = Produit::find($produit->id);
        // Redirige vers la view avec un paramètre
        return view('modifProduit', ["produitModif" => $produitModif]);
    }
    /**
     * [Fonction qui permet d'enregistrer un nouveau produit dans la BDD]
     * @param  ProduitRequest $request [Récupère les données contrôlées par la Request]
     * @return [route]                  [Dirige vers la vue de la liste des produits]
     */
    public function ajouterProduit(ProduitRequest $request){

        // Récupère le nom de l'image plus le temps pour que l'image soit unique lors de la sauvegarde
        $image = time().$_FILES['img']['name'];

        // Sauvegarder une image
        $request->file('img')->storePubliclyAs('public/image/', $image);

        // Création d'une instance
        $produit = new Produit();
        // Assignation des attributs
        $produit->titre = $request->titre;
        $produit->img = $image;
        $produit->message = $request->message;
        // Requête INSERT INTO vers la BDD
        $produit->save();

        // Redirige vers la page d'accueil
        return redirect()->route('listeP');
    }
    /**
     * [Suppresion d'un produit dans la BDD]
     * @param  Produit $produit [Récupèration de l'ID du produit]
     * @return [Route]           [Redirige vers la vue de la liste des produits après suppression]
     */
        public function supprimerProduit(Produit $produit){
        
        // Suppression l'image dans le dossier image
        Storage::delete('public/image/'.$produit->img);
        // Requête SQL DELETE
        $produit->delete();
        // Redirige vers l'accueil
        return redirect()->route('listeP');
    }

    /**
     * [modifierProduit description]
     * @param  ProduitModifRequest $request [description]
     * @return [view]           [Redirige vers la vue de la liste des produits après modification]
     */
    public function modifierProduit(ProduitModifRequest $request){

        // Récupération d'un tuple (=entrée) avec l'ID dans une BDD 
        $produit = Produit::find($request->id);
        
        // Vérifie s'il y a un fichier
        if ($request->hasFile('img')) {

            $produit->img = $request->img2;
            // Suppression de l'ancienne image dans le dossier image
            Storage::delete('public/image/'.$produit->img);

            // Récupère le nom de l'image plus le temps pour que l'image soit unique lors de la sauvegarde
            $image = time().$_FILES['img']['name'];

            // Sauvegarder une image
            $request->file('img')->storePubliclyAs('public/image/', $image);
            $produit->img = $image;
        
        }else{
            // Récupération du nom de l'image non modifier
            $produit->img = $request->img2;
        }
        // Assignation des attributs
        $produit->titre = $request->titre;        
        $produit->message = $request->message;
        $produit->save();
        // Redirige vers l'accueil
        return redirect()->route('listeP');
    }
}
