<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Admin\NewsletterController as AdminNewsletterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Accueil & Langue ---
Route::get('/', function () {
    // On utilise le nouveau nom correct 'newsletter.form'
    return redirect()->route('newsletter.form');
})->name('home');

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['fr', 'en', 'es'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

// --- Newsletter (Public) ---
// Note : J'ai enlevé le ->name('newsletter.') pour éviter le double préfixe
Route::prefix('newsletter')->group(function () {
    Route::get('/', [NewsletterController::class, 'showForm'])->name('newsletter.form');
    Route::post('/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
    Route::get('/thanks', [NewsletterController::class, 'thanks'])->name('newsletter.thanks');
    Route::get('/unsubscribe', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
});

// --- Dashboard & Profil (Privé / Authentifié) ---
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Administration Newsletter ---
    Route::prefix('admin/newsletter')->name('admin.newsletter.')->group(function () {
        Route::get('/', [AdminNewsletterController::class, 'index'])->name('index');
        Route::get('/campaign', [AdminNewsletterController::class, 'createCampaign'])->name('campaign');
        Route::post('/campaign/send', [AdminNewsletterController::class, 'sendCampaign'])->name('send');
        Route::get('/export', [AdminNewsletterController::class, 'export'])->name('export');
        Route::delete('/{newsletter}', [AdminNewsletterController::class, 'destroy'])->name('destroy');
    });
});

// --- Outils Système (À supprimer après déploiement) ---
Route::get('/init-db', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return "✅ Base de données migrée avec succès sur Supabase !";
    } catch (\Exception $e) {
        return "❌ Erreur : " . $e->getMessage();
    }
});

require __DIR__.'/auth.php';
