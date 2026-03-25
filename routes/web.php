<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Admin\NewsletterController as AdminNewsletterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Accueil : Redirection vers le formulaire
Route::get('/', function () {
    return redirect()->route('newsletter.form');
})->name('home');

// Switcher de langue (Stocké en session)
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['fr', 'en', 'es'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

// ==========================================================
// SECTION PUBLIQUE : NEWSLETTER
// ==========================================================
Route::prefix('newsletter')->group(function () {

    // Affichage du formulaire
    Route::get('/', [NewsletterController::class, 'showForm'])
        ->name('newsletter.form');

    // Inscription (POST)
    Route::post('/subscribe', [NewsletterController::class, 'subscribe'])
        ->name('newsletter.subscribe');

    // Page de succès
    Route::get('/thanks', [NewsletterController::class, 'thanks'])
        ->name('newsletter.thanks');

    // Désabonnement (Supporte Token ou Email)
    Route::get('/unsubscribe/{email_or_token}', [NewsletterController::class, 'unsubscribe'])
        ->name('newsletter.unsubscribe');
});

// ==========================================================
// SECTION PRIVÉE : DASHBOARD & ADMIN (AUTH)
// ==========================================================
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Gestion du profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Gestion administrative de la Newsletter
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

// ==========================================================
// SECTION OUTILS SYSTEME (Maintenance Vercel/Supabase)
// ==========================================================
// Note : En production, vous devriez protéger ces routes par un middleware de sécurité
Route::prefix('sys')->group(function () {

    // 1. Migration de la base de données (Supabase)
    Route::get('/migrate', function () {
        try {
            // --force est obligatoire en production/Vercel
            Artisan::call('migrate', ['--force' => true]);
            $output = Artisan::output();
            return "✅ Migration réussie ! <br><pre>$output</pre>";
        } catch (\Exception $e) {
            Log::error("Erreur Migration: " . $e->getMessage());
            return "❌ Erreur de migration : " . $e->getMessage();
        }
    });

    // 2. Nettoyage complet du cache (Configuration, Routes, Vues)
    Route::get('/clear-all', function() {
        try {
            Artisan::call('config:clear');
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');
            return "✅ Cache Laravel entièrement nettoyé sur Vercel !";
        } catch (\Exception $e) {
            return "❌ Erreur lors du nettoyage : " . $e->getMessage();
        }
    });

    // 3. Test de connexion brute à la DB (Diagnostic Supabase)
    Route::get('/test-db', function () {
        try {
            \DB::connection()->getPdo();
            return "✅ Connexion à Supabase (" . config('database.connections.pgsql.host') . ") établie !";
        } catch (\Exception $e) {
            return "❌ Échec de connexion : " . $e->getMessage();
        }
    });
});

require __DIR__.'/auth.php';
