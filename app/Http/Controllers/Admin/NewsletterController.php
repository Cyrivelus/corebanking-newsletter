<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Mail\NewsletterCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    /**
     * Afficher la liste des inscrits
     */
    public function index()
    {
        // On récupère les abonnés avec pagination
        $subscribers = Newsletter::latest()->paginate(15);
        $totalSubscribers = Newsletter::where('is_subscribed', true)->count();

        return view('admin.newsletter.index', compact('subscribers', 'totalSubscribers'));
    }

    /**
     * Afficher le formulaire de création de campagne
     */
    public function createCampaign()
    {
        $totalSubscribers = Newsletter::where('is_subscribed', true)->count();

        return view('admin.newsletter.campaign', compact('totalSubscribers'));
    }

    /**
     * Envoyer la campagne à tous les abonnés actifs
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
            // L'utilisation de queue() est parfaite ici grâce à notre configuration précédente
            Mail::to($subscriber->email)->queue(new NewsletterCampaign(
                $subscriber,
                $request->subject,
                $request->content
            ));
        }

        return redirect()->route('admin.newsletter.index')
            ->with('success', "La campagne a été mise en file d'attente pour {$subscribers->count()} abonnés !");
    }

    /**
     * Exporter la liste en CSV
     */
    public function export()
    {
        $subscribers = Newsletter::where('is_subscribed', true)->get();

        $csv = "Email,Nom,Date d'inscription\n";

        foreach ($subscribers as $subscriber) {
            $date = $subscriber->subscribed_at ? $subscriber->subscribed_at->format('Y-m-d H:i') : $subscriber->created_at->format('Y-m-d H:i');
            $csv .= "{$subscriber->email},{$subscriber->name},{$date}\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="newsletter-subscribers.csv"');
    }

    /**
     * Supprimer un abonné de la base
     */
    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();

        return redirect()->route('admin.newsletter.index')
            ->with('success', 'L\'abonné a été supprimé avec succès.');
    }
}
