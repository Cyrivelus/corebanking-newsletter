<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns|max:255',
            'name'  => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // On vérifie manuellement l'unicité pour attraper l'erreur de connexion ici
            $exists = Newsletter::where('email', $request->email)->exists();

            if ($exists) {
                return redirect()->back()->withErrors(['email' => __('Cet email est déjà inscrit.')])->withInput();
            }

            Newsletter::create([
                'email' => filter_var($request->email, FILTER_SANITIZE_EMAIL),
                'name'  => strip_tags($request->name),
            ]);

            return redirect()->route('newsletter.thanks');

        } catch (QueryException $e) {
            // Si Supabase rejette encore la connexion, on affiche un message propre
            return redirect()->back()
                ->withErrors(['db_error' => 'Erreur de connexion à la base de données. Vérifiez la configuration du Pooler.'])
                ->withInput();
        }
    }
}
