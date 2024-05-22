<?php

namespace App\Console;

use Carbon\Carbon;
use App\Models\devi;
use App\Models\facture;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\DeviController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        /**
         * SUPPRIMER TOUS LES DEVIS ET LES FACTURES QUI SONT EXPIREÉS
         */
        $schedule->call( function()
        {
            Log::info('Starting scheduled task for deleting expired Devis and Factures.');
            
            $allDevis = devi::all();
            $allFactures = facture::all();

            /** PATRIE DES DEVIS */
            foreach($allDevis as $devis)
            {
                $dateLimite = Carbon::parse($devis->created_at)->addHours(25);

                if($dateLimite <= now())
                {
                    $demande = $devis->demande;
                    DeviController::deletePDF($demande->id);
                    $demande->update(['statut' => 'refuse']);  //'annule']);
                }
            }
            /** PARTIE DES FACTURES */
            foreach($allFactures as $facture)
            {
                $devis = $facture->devi;
                $demande = $devis->demande;

                $dateLimite = Carbon::parse($demande->updated_at)->addDays(15);

                if($dateLimite <= now())
                {
                    DeviController::deletePDF($demande->id, 'facture');
                    $demande->update(['statut' => 'refuse']);  //'annule']);
                }
            }
        })->everyTwoHours();

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
