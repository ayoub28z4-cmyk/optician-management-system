<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrdonnanceController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\SocieteController;
use App\Http\Controllers\TypeArticleController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\SyntheseRetraitsController;
use App\Http\Controllers\VenteController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Opticien\DashboardController as OpticienDashboard;
use App\Http\Controllers\Employe\DashboardController as EmployeDashboard;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\RappelController;
use App\Http\Controllers\RendezVousController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        return match($user->role) {
            'admin'    => redirect()->route('admin.dashboard'),
            'opticien' => redirect()->route('opticien.dashboard'),
            'employe'  => redirect()->route('employe.dashboard'),
            default    => redirect()->route('login'),
        };
    }
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin
    Route::middleware('role:admin')
        ->prefix('admin')->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        });
    // Admin — Gestion utilisateurs
    Route::middleware('role:admin')
        ->prefix('admin')->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
            Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(['show']);
        });

    // Opticien
    Route::middleware('role:opticien')
        ->prefix('opticien')->name('opticien.')
        ->group(function () {
            Route::get('/dashboard', [OpticienDashboard::class, 'index'])->name('dashboard');
        });

    // Employé
    Route::middleware('role:employe')
        ->prefix('employe')->name('employe.')
        ->group(function () {
            Route::get('/dashboard', [EmployeDashboard::class, 'index'])->name('dashboard');
        });

    // Clients + Ordonnances + Ventes
    Route::middleware('role:opticien,employe')
        ->group(function () {
            Route::resource('clients', ClientController::class);
            Route::resource('clients.ordonnances', OrdonnanceController::class);
            Route::resource('ventes', VenteController::class)->except(['destroy']);
            Route::get('ventes/{vente}/print', [VenteController::class, 'print'])
                 ->name('ventes.print');
        });

    // Paiements
    Route::middleware('role:opticien,employe')
        ->group(function () {
            Route::post('ventes/{vente}/paiements', [PaiementController::class, 'store'])
                ->name('ventes.paiements.store');
            Route::delete('ventes/{vente}/paiements/{paiement}', [PaiementController::class, 'destroy'])
                ->name('ventes.paiements.destroy');
        });

    // Rendez-vous
    Route::middleware('role:opticien,employe')
        ->group(function () {
            Route::resource('rendez-vous', RendezVousController::class)->except(['show']);
        });

    // Vue globale ordonnances
    Route::middleware('role:opticien,employe')
        ->get('/ordonnances', function () {
            $clients = \App\Models\Client::with(['derniereOrdonnance'])
                ->whereHas('ordonnances')
                ->where('is_active', true)
                ->orderBy('classement_registre')
                ->paginate(10);
            return view('ordonnances.global', compact('clients'));
        })->name('ordonnances.index');

    // Rappels
    Route::middleware('role:opticien,employe')
        ->group(function () {
            Route::get('rappels', [RappelController::class, 'index'])->name('rappels.index');
            Route::put('rappels/{rappel}', [RappelController::class, 'update'])->name('rappels.update');
        });

    // Page dédiée paiements
    Route::middleware('role:opticien,employe')
        ->get('/paiements', function () {
            $paiements = \App\Models\Paiement::with(['vente.client', 'user'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            return view('paiements.index', compact('paiements'));
        })->name('paiements.index');

    // ─── Gestion de stock (nouveau système) ────────────────────────────────
    Route::middleware(['role:opticien,employe', 'journal.requetes'])
        ->group(function () {
            // Import / Export
            Route::post('/articles/exporter', [ArticleController::class, 'exporter'])
                 ->name('articles.exporter');
            Route::post('/articles/importer', [ArticleController::class, 'importer'])
                 ->name('articles.importer');

            // Sélection retrait en 2 étapes
            Route::get('/articles/retrait-selection', [ArticleController::class, 'retraitSelectionForm'])
                 ->name('articles.retrait.selection.form');
            Route::post('/articles/retrait-selection', [ArticleController::class, 'retraitSelection'])
                 ->name('articles.retrait.selection');

            // CRUD articles
            Route::resource('articles', ArticleController::class)->except(['show']);

            // Formulaire de retrait
            Route::get('/articles/{article}/retirer', [ArticleController::class, 'retirerForm'])
                 ->name('articles.retirer.form');
            Route::post('/articles/{article}/retirer', [ArticleController::class, 'retirer'])
                 ->name('articles.retirer');

            // Sociétés / Marques
            Route::resource('societes', SocieteController::class)->only(['index', 'store', 'destroy']);

            // Types d'articles
            Route::resource('types-articles', TypeArticleController::class)
                ->only(['index', 'store', 'destroy'])
                ->parameters(['types-articles' => 'typesArticle']);

            // Désignations
            Route::resource('designations', DesignationController::class)->only(['index', 'store', 'destroy']);

        });

    // ─── Tableau de bord stock (admin uniquement) ──────────────────────────
    Route::middleware(['role:admin', 'journal.requetes'])
        ->get('/retraits/synthese', [SyntheseRetraitsController::class, 'index'])
        ->name('retraits.synthese');

});

// API interne — ordonnances par client
Route::get('api/clients/{client}/ordonnances', function (\App\Models\Client $client) {
    return $client->ordonnances()
                  ->select('id', 'date_ordonnance', 'medecin')
                  ->get()
                  ->map(fn($o) => [
                      'id'               => $o->id,
                      'date_ordonnance'  => $o->date_ordonnance->format('d/m/Y'),
                      'medecin'          => $o->medecin,
                  ]);
})->middleware('auth')->name('api.clients.ordonnances');

require __DIR__.'/auth.php';
