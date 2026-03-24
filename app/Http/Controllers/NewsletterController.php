<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use App\Mail\NewsletterWelcome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class NewsletterController extends Controller
{
    public function showForm()
    {
        return view('newsletter.subscribe');
    }

    public function subscribe(Request $request)
    {
        // Validation stricte pour éviter les injections de scripts
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns|unique:newsletters,email|max:255',
            'name'  => 'nullable|string|strip_tags|max:100', // strip_tags évite le JS malveillant
        ]);

        if ($validator->fails()) {
            return redirect()->to('/newsletter')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $newsletter = Newsletter::create([
                'email' => filter_var($request->email, FILTER_SANITIZE_EMAIL),
                'name'  => htmlspecialchars($request->name),
            ]);

            // Envoi de l'email
            Mail::to($newsletter->email)->send(new NewsletterWelcome($newsletter));

            // Redirection explicite vers l'URL complète pour éviter l'alerte "Redirector"
            return redirect()->to(config('app.url') . '/newsletter/thanks')
                ->with('success', 'Inscription réussie !');

        } catch (\Exception $e) {
            Log::error("Erreur Newsletter: " . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur technique est survenue.');
        }
    }

    public function thanks() { return view('newsletter.thanks'); }

    public function unsubscribe($token)
    {
        // On sanitize le token pour éviter les attaques par URL
        $cleanToken = preg_replace('/[^a-zA-Z0-9]/', '', $token);
        $newsletter = Newsletter::where('token', $cleanToken)->firstOrFail();

        if ($newsletter->is_subscribed) {
            $newsletter->unsubscribe();
            return view('newsletter.unsubscribed', ['email' => $newsletter->email]);
        }
        return redirect()->to('/');
    }

    public function resubscribe($token)
    {
        $cleanToken = preg_replace('/[^a-zA-Z0-9]/', '', $token);
        $newsletter = Newsletter::where('token', $cleanToken)->firstOrFail();
        $newsletter->resubscribe();

        return redirect()->to('/newsletter/thanks');
    }
}
