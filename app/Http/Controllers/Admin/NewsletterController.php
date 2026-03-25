<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;
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
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns|unique:newsletters,email|max:255',
            'name'  => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Newsletter::create([
                'email' => filter_var($request->email, FILTER_SANITIZE_EMAIL),
                'name'  => strip_tags($request->name),
                'is_subscribed' => true,
            ]);

            return redirect()->route('newsletter.thanks')
                ->with('success', __('Merci pour votre inscription !'));

        } catch (\Illuminate\Database\QueryException $e) {
            Log::error("Erreur Inscription Newsletter: " . $e->getMessage());

            return redirect()->back()
                ->withErrors(['db_error' => __('Une erreur technique est survenue. Veuillez réessayer plus tard.')])
                ->withInput();
        }
    }

    public function thanks()
    {
        return view('newsletter.thanks');
    }

    public function unsubscribe(Request $request, $token = null)
    {
        // Logique de désabonnement via token ou email
        $email = $request->query('email');
        $subscriber = Newsletter::where('email', $email)->first();

        if ($subscriber) {
            $subscriber->update(['is_subscribed' => false]);
        }

        return view('newsletter.unsubscribed_success', ['email' => $email]);
    }
}
