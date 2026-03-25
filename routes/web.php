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

// Accueil
Route::get('/', function () {
    return redirect()->route('newsletter.form');
})->name('home');

// Langue
Route::get('lang/{locale}', function ($locale) {

    if (in_array($locale, ['fr', 'en', 'es'])) {
        session(['locale' => $locale]);
    }

    return redirect()->back();

})->name('lang.switch');


// =============================
// NEWSLETTER PUBLIC
// =============================

Route::prefix('newsletter')->group(function () {

    // page formulaire
    Route::get('/', [NewsletterController::class, 'showForm'])
        ->name('newsletter.form');

    // abonnement
    Route::post('/subscribe', [NewsletterController::class, 'subscribe'])
        ->name('newsletter.subscribe');

    // page merci
    Route::get('/thanks', [NewsletterController::class, 'thanks'])
        ->name('newsletter.thanks');

    // désabonnement
    Route::get('/unsubscribe', [NewsletterController::class, 'unsubscribe'])
        ->name('newsletter.unsubscribe');
});


// =============================
// DASHBOARD AUTH
// =============================

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    // =============================
    // ADMIN NEWSLETTER
    // =============================

    Route::prefix('admin/newsletter')
        ->name('admin.newsletter.')
        ->group(function () {

            Route::get('/', [AdminNewsletterController::class, 'index'])
                ->name('index');

            Route::get('/campaign', [AdminNewsletterController::class, 'createCampaign'])
                ->name('campaign');

            Route::post('/campaign/send', [AdminNewsletterController::class, 'sendCampaign'])
                ->name('send');

            Route::get('/export', [AdminNewsletterController::class, 'export'])
                ->name('export');

            Route::delete('/{newsletter}', [AdminNewsletterController::class, 'destroy'])
                ->name('destroy');
        });
});


// =============================
// INIT DATABASE (TEMPORAIRE)
// =============================

Route::get('/init-db', function () {

    try {

        Artisan::call('migrate', ['--force' => true]);

        return "✅ Base de données migrée avec succès sur Supabase !";

    } catch (\Exception $e) {

        return "❌ Erreur : " . $e->getMessage();
    }

});


require __DIR__.'/auth.php';
