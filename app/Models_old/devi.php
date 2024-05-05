<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class devi extends Model
{
    use HasFactory;

    protected $fillable = [ 'statut','motif_refus','tarif_ht','tarif_ttc','tva','devi_pdf','parentmodel_id'];

   
    public function parentmodel():BelongsTo
    {
        return $this->belongsTo(parentmodel::class);
    }

    public function facture():HasOne
    {
        return $this->HasOne(facture::class);
    }
}
