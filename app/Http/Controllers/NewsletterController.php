<?php
// app/Http/Controllers/NewsletterController.php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use App\Mail\NewsletterWelcome;
use App\Mail\NewsletterCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    /**
     * Afficher le formulaire d'inscription
     */
    public function showForm()
    {
        return view('newsletter.subscribe');
    }

    /**
     * S'inscrire à la newsletter
     */
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:newsletters,email',
            'name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $newsletter = Newsletter::create([
            'email' => $request->email,
            'name' => $request->name,
        ]);

        // Envoyer email de bienvenue
        Mail::to($newsletter->email)->send(new NewsletterWelcome($newsletter));

        return redirect()->route('newsletter.thanks')
            ->with('success', 'Merci de vous être inscrit à notre newsletter !');
    }

    /**
     * Page de remerciement
     */
    public function thanks()
    {
        return view('newsletter.thanks');
    }

    /**
     * Se désinscrire de la newsletter
     */
    public function unsubscribe($token)
    {
        $newsletter = Newsletter::where('token', $token)->firstOrFail();

        if ($newsletter->is_subscribed) {
            $newsletter->unsubscribe();

            return view('newsletter.unsubscribed', [
                'email' => $newsletter->email
            ]);
        }

        return redirect()->route('home');
    }

    /**
     * Se réinscrire
     */
    public function resubscribe($token)
    {
        $newsletter = Newsletter::where('token', $token)->firstOrFail();

        $newsletter->resubscribe();

        return redirect()->route('newsletter.thanks')
            ->with('success', 'Vous êtes de nouveau inscrit à notre newsletter !');
    }

    /**
     * Vérifier le statut (API)
     */
    public function checkStatus(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $subscriber = Newsletter::where('email', $request->email)->first();

        return response()->json([
            'subscribed' => $subscriber ? $subscriber->is_subscribed : false,
            'email' => $request->email
        ]);
    }
}
