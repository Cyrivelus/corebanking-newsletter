<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Mail\NewsletterCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Carbon\Carbon; // Importé pour les statistiques de date

class NewsletterController extends Controller
{
    /**
     * Afficher la liste des inscrits et les statistiques
     */
    public function index()
    {
        // 1. Récupération des abonnés pour le tableau
        $subscribers = Newsletter::latest()->paginate(15);

        // 2. Statistiques globales
        $totalActive = Newsletter::where('is_subscribed', true)->count();
        $totalUnsubscribed = Newsletter::where('is_subscribed', false)->count();

        // 3. Statistiques du mois en cours
        $startOfMonth = Carbon::now()->startOfMonth();

        $newThisMonth = Newsletter::where('created_at', '>=', $startOfMonth)->count();

        $unsubsThisMonth = Newsletter::where('is_subscribed', false)
                            ->where('updated_at', '>=', $startOfMonth)
                            ->count();

        return view('admin.newsletter.index', compact(
            'subscribers',
            'totalActive',
            'totalUnsubscribed',
            'newThisMonth',
            'unsubsThisMonth'
        ));
    }

    /**
     * Formulaire de campagne
     */
    public function createCampaign()
    {
        $totalSubscribers = Newsletter::where('is_subscribed', true)->count();
        return view('admin.newsletter.campaign', compact('totalSubscribers'));
    }

    /**
     * Envoi de la campagne (Local vs Prod)
     */
    public function sendCampaign(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $subscribers = Newsletter::where('is_subscribed', true)->get();

        if ($subscribers->isEmpty()) {
            return redirect()->back()->with('error', "Aucun abonné actif pour l'envoi.");
        }

        foreach ($subscribers as $subscriber) {
            $email = Mail::to($subscriber->email);

            // Si local : envoi synchrone (immédiat dans le log)
            // Si prod : envoi asynchrone (file d'attente)
            if (App::environment('local')) {
                $email->send(new NewsletterCampaign($subscriber, $request->subject, $request->content));
            } else {
                $email->queue(new NewsletterCampaign($subscriber, $request->subject, $request->content));
            }
        }

        $message = App::environment('local')
            ? "Campagne envoyée avec succès (Mode Local) !"
            : "La campagne a été mise en file d'attente pour {$subscribers->count()} abonnés !";

        return redirect()->route('admin.newsletter.index')->with('success', $message);
    }

    /**
     * Export CSV des abonnés actifs
     */
    public function export()
    {
        $subscribers = Newsletter::where('is_subscribed', true)->get();

        $csv = "Email,Nom,Date d'inscription\n";
        foreach ($subscribers as $subscriber) {
            $date = $subscriber->created_at->format('Y-m-d H:i');
            $csv .= "{$subscriber->email},{$subscriber->name},{$date}\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="newsletter-subscribers.csv"');
    }

    /**
     * Supprimer définitivement un abonné
     */
    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();
        return redirect()->route('admin.newsletter.index')
            ->with('success', 'L\'abonné a été supprimé avec succès.');
    }

    /**
     * Gérer le désabonnement (Public)
     */
    public function unsubscribe(Request $request)
    {
        $email = $request->query('email');

        if (!$email) {
            return redirect('/')->with('error', 'Lien de désabonnement invalide.');
        }

        $subscriber = Newsletter::where('email', $email)->first();

        if ($subscriber) {
            // On passe le statut à false au lieu de supprimer
            $subscriber->update(['is_subscribed' => false]);
        }

        return view('newsletter.unsubscribed_success', compact('email'));
    }
}
