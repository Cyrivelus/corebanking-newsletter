<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Newsletter;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendWeeklyNewsletterReport extends Command
{
    // Le nom de la commande à taper dans le terminal
    protected $signature = 'report:newsletter-weekly';
    protected $description = 'Envoie un rapport hebdomadaire des abonnés à l\'admin';

    public function handle()
    {
        $lastWeek = Carbon::now()->subDays(7);

        $totalActive = Newsletter::where('is_subscribed', true)->count();
        $newThisWeek = Newsletter::where('created_at', '>=', $lastWeek)->count();
        $unsubsThisWeek = Newsletter::where('is_subscribed', false)
                            ->where('updated_at', '>=', $lastWeek)
                            ->count();

        $adminEmail = config('mail.from.address'); // Ou ton email direct

        // On envoie un mail simple à l'admin
        Mail::raw("Rapport Hebdomadaire Newsletter :\n\n" .
                 "- Abonnés Actifs : $totalActive\n" .
                 "- Nouveaux Inscrits (7j) : +$newThisWeek\n" .
                 "- Désabonnements (7j) : $unsubsThisWeek\n\n" .
                 "Consultez le dashboard : " . url('/admin/newsletter'),
        function ($message) use ($adminEmail) {
            $message->to($adminEmail)
                    ->subject("📊 Rapport Hebdomadaire - CoreBanking Newsletter");
        });

        $this->info('Rapport envoyé avec succès à ' . $adminEmail);
    }
}
