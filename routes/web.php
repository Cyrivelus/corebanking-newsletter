<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Admin\NewsletterController as AdminNewsletterController;
use Illuminate\Support\Facades\Route;

// --- Accueil ---
Route::get('/', function () {
    return view('welcome');
});

// --- Newsletter (Public) ---
Route::get('/newsletter', [NewsletterController::class, 'showForm'])->name('newsletter.form');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/thanks', [NewsletterController::class, 'thanks'])->name('newsletter.thanks');
Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// --- Dashboard & Profil (Privé) ---
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Admin Newsletter (Routes ajoutées ici) ---
    Route::prefix('admin')->name('admin.')->group(function () {
        // Liste des abonnés
        Route::get('/newsletter', [AdminNewsletterController::class, 'index'])->name('newsletter.index');

        // Création et envoi de campagne (Les routes qui manquaient !)
        Route::get('/newsletter/campaign', [AdminNewsletterController::class, 'createCampaign'])->name('newsletter.campaign');
        Route::post('/newsletter/campaign/send', [AdminNewsletterController::class, 'sendCampaign'])->name('newsletter.send');

        // Export et Suppression
        Route::get('/newsletter/export', [AdminNewsletterController::class, 'export'])->name('newsletter.export');
        Route::delete('/newsletter/{newsletter}', [AdminNewsletterController::class, 'destroy'])->name('newsletter.destroy');
    });
});

require __DIR__.'/auth.php';
