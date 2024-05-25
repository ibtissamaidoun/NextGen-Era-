<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recu extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_paiement',
        'traite',
        'total_traite',
        'tarif',
        'date_prochain_paiement',
        'facture_id',
        'recu_pdf'
    ];

    // Relation avec la table factures
    public function facture()
    {
        return $this->belongsTo(Facture::class);
    }
}
