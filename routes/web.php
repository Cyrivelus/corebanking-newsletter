<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Admin\NewsletterController as AdminNewsletterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// Accueil : Redirection vers le formulaire
Route::get('/', function () {
    return redirect()->route('newsletter.form');
})->name('home');

// Switcher de langue
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['fr', 'en', 'es'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

// =============================
// NEWSLETTER PUBLIQUE
// =============================
Route::prefix('newsletter')->group(function () {

    // Page du formulaire (GET)
    Route::get('/', [NewsletterController::class, 'showForm'])
        ->name('newsletter.form');

    // Traitement de l'abonnement (POST)
    Route::post('/subscribe', [NewsletterController::class, 'subscribe'])
        ->name('newsletter.subscribe');

    // Page de remerciement (GET)
    Route::get('/thanks', [NewsletterController::class, 'thanks'])
        ->name('newsletter.thanks');

    // Désabonnement (GET)
    Route::get('/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])
        ->name('newsletter.unsubscribe');
});

// =============================
// DASHBOARD & ADMIN (AUTH)
// =============================
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin/newsletter')
        ->name('admin.newsletter.')
        ->group(function () {
            Route::get('/', [AdminNewsletterController::class, 'index'])->name('index');
            Route::get('/campaign', [AdminNewsletterController::class, 'createCampaign'])->name('campaign');
            Route::post('/campaign/send', [AdminNewsletterController::class, 'sendCampaign'])->name('send');
            Route::get('/export', [AdminNewsletterController::class, 'export'])->name('export');
            Route::delete('/{newsletter}', [AdminNewsletterController::class, 'destroy'])->name('destroy');
        });
});

// =============================
// OUTILS (TEMPORAIRE)
// =============================
Route::get('/init-db', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return "✅ Base de données migrée avec succès !";
    } catch (\Exception $e) {
        return "❌ Erreur : " . $e->getMessage();
    }
});

require __DIR__.'/auth.php';
