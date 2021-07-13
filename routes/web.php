<?php

use App\Models\Articles;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\FormulaireController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\HommageController;
use Faker\Provider\Lorem;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route permet de grouper et assigner un middleware à toutes les routes
// Middleware fonctionne un peu comme un filtre avant d'accéder aux routes, là en l'occurrence il dirige vers le fichier web 
Route::group(["middleware" => "web"], function(){

// =================================Route ARTICLE================================= 

    // Route pour la page d'accueil
    Route::get('/', [ArticleController::class, 'Accueil_calendrier']);

    // Route pour aller à l'article
    Route::get('/modifArticles/{article}', [ArticleController::class, 'getArticle']);

    // Route pour aller sur la page d'ajout de l'article
    Route::get('AddArticle', [ArticleController::class, 'listeArticle'])->name('add');

    // Route pour ajouter un article
    Route::post('/articles', [ArticleController::class, 'ajouterArticle']);

    // Route pour supprimer un article
    Route::delete('/articles/{article}', [ArticleController::class, 'supprimerArticle']);

    // Route pour aller à la page de modification de l'article
    Route::get('/articles/{article}', [ArticleController::class, 'edit'])->name('edit');

    // Route pour modifier un article
    Route::put('/modifArticle', [ArticleController::class, 'modifierArticle']);

// =================================Route CALENDRIER================================= 

    // Route pour aller au mois suivant
    Route::post('nextRoute', [CalendarController::class, 'affichageCalendarNextMonth']); 

    // Route pour aller au mois précédent
    Route::post('prevRoute', [CalendarController::class, 'affichageCalendarPrevMonth']); 

// =================================Route FORMULAIRE================================= 

    // Route pour aller à la page du formulaire de contact
    Route::get('formulaire', [FormulaireController::class, 'create']);
    // Route pour envoyer le formulaire de contact par mail
    Route::post('formulaire', [FormulaireController::class, 'store']);
    
// =================================Route NEWSLETTER=================================     

    // Route pour envoyer un mail de contact
    Route::post('newsletter', [FormulaireController::class, 'store']);

    // Route aller sur la page de la newsletter
    Route::get('newsletter', [NewsletterController::class, 'create']);

    // Route pour enregistrer l'abonnement
    Route::post('abonnement', [NewsletterController::class, 'store']);

    // Route pour aller sur la page de desabonnement
    Route::get('desabonnement', [NewsletterController::class, 'desabonner']);

    // Route pour se desabonner
    Route::post('desabonner', [NewsletterController::class, 'desabo']);


// =================================Route EVENT=================================     

    // Route pour effacer les events passés la date du jour
    Route::post('event', [CrudController::class, 'autoSuppression']);

    //route d'affichage de tous les événements dans l'ordre du plus récent
    Route::get('allEvent',[CrudController::class, 'afficherTous']);

    // Route pour ajouter un event
    Route::post('/calendrier',  [CrudController::class, 'ajouterEvent'] )->name('creation');
    
    // Route pour supprimer un event
    Route::delete('/supprimer', [CrudController::class, 'supprimerEvent'] )->name('supprimer'); 

    // Route pour aller à la page modif de l'event
    Route::put('/modifEvent', [CrudController::class, 'modifierEvent'] )->name('modifEvent'); 

    // Route pour modifier l'event
    Route::put('/modifier', [CrudController::class, 'edit'] )->name('modifier'); 

// =================================Route PRODUIT=================================     

    // Route pour la page d'accueil des produits
    Route::get('/listeProduit', [ProduitController::class, 'listeProduit'])->name('listeP');

    // Route pour ajouter un produit
    Route::post('/addProduit', [ProduitController::class, 'ajouterProduit']);

    // Route pour aller à la page de modification du produit
    Route::get('/modifProduits/{produit}', [ProduitController::class, 'editProduit'])->name('editProduit');

    // Route pour modifier un hommage
    Route::put('/modifProduit', [ProduitController::class, 'modifierProduit']);

    // Route pour supprimer un hommage
    Route::delete('/produits/{produit}', [ProduitController::class, 'supprimerProduit']);

    // Route pour aller à la page du produit
    Route::get('/produits/{produit}', [ProduitController::class, 'getProduit'])->name('getProduit');

// =================================Route HOMMAGE=================================     

    // Route pour la page d'accueil des hommages
    Route::get('/listeHommage', [HommageController::class, 'listeHommage'])->name('listeH');

    // Route pour ajouter un hommage
    Route::post('/addHommage', [HommageController::class, 'ajouterHommage']);

    // Route pour aller à la page de modification de l'hommage
    Route::get('/hommages/{hommage}', [HommageController::class, 'editHommage'])->name('editHommage');

    // Route pour modifier un hommage
    Route::put('/modifHommage', [HommageController::class, 'modifierHommage']);

    // Route pour supprimer un hommage
    Route::delete('/hommages/{hommage}', [HommageController::class, 'supprimerHommage']);

// =================================Route BIO=================================     

    // Route pour aller sur la page Bio
    Route::view('/bio', 'bio');

});

    // Route pour l'authentification
    Route::get('/dashboard', [ArticleController::class, 'Accueil_calendrier']);

    require __DIR__.'/auth.php';