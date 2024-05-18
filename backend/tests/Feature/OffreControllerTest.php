<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Offre;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Models\Administrateur;
use App\Models\Paiement;
use App\Models\Activite;

  class OffreControllerTest extends TestCase
{
     use RefreshDatabase, WithoutMiddleware;
    public function testdeleteunsuccefully()
    {
        $IdNotExiste = 999;  // veux dire que id not existe
        $response = $this->deleteJson("api/offres/{$IdNotExiste}");
        $response->assertStatus(404);
        $response->assertJson(['message' => 'offre non trouve']);
    }
    public function testdeletesuccefully()
    {

        $offre = Offre::factory()->create();
        $response = $this->deleteJson("api/offres/{$offre->id}");
        $this->assertDatabaseMissing('offres', ['id' => $offre->id]);
        $response->assertStatus(200);
        $response->assertJson(['message' => 'offre deleted successfuly']);
    }
    public function testStoreInvalidData()
    {
        $response = $this->postJson('/api/offres', [
            'titre' => '',
            'description' => '',
            'date_debut_inscription' => '',
            'date_fin_inscription' => '',
            'activites' => []
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function testStoreValidData()
    {
        $administrateur = Administrateur::factory()->create();
        $paiement = Paiement::factory()->create();
        $activite = Activite::factory()->create();

        $validData = [
            'titre' => 'Nouvelle Offre',
            'description' => 'Description de l\'offre.',
            'remise' => 10,
            'date_debut_inscription' => '2024-01-01',
            'date_fin_inscription' => '2024-01-31',
            'administrateur_id' => $administrateur->id,
            'paiement_id' => $paiement->id,
            'activites' => [
                ['id' => $activite->id]
            ]
        ];

        $response = $this->postJson('/api/offres', $validData);

        $response->assertStatus(201);
        $response->assertJson([
            'message' => 'Offer created successfully',
            'offer' => [
                'titre' => 'Nouvelle Offre',
                'description' => 'Description de l\'offre.',
                'remise' => 10,
                'date_debut_inscription' => '2024-01-01',
                'date_fin_inscription' => '2024-01-31',
                'administrateur_id' => $administrateur->id,
                'paiement_id' => $paiement->id,
                'activites' => [['id' => $activite->id]]
            ]
        ]);

        $this->assertDatabaseHas('offres', [
            'titre' => 'Nouvelle Offre',
            'description' => 'Description de l\'offre.'

        ]);

        $createdOffer = Offre::first();
        $this->assertEquals(1, $createdOffer->getActivites()->count());
        $this->assertTrue($createdOffer->getActivites()->first()->id === $activite->id);
    }
    public function testUpdateOffreNotFound()
    {
        $response = $this->putJson('/api/offres/999', []);
        $response->assertStatus(404);
    }

    public function testUpdateInvalideData()
    {
        $offre = Offre::factory()->create();
        $response = $this->putJson("/api/offres/{$offre->id}", [
            'titre' => '',
        ]);

        $response->assertStatus(422);
    }

    public function testUpdateValideTada()
    {
        $offre = Offre::factory()->create();
        $administrateur = Administrateur::factory()->create();
        $paiement = Paiement::factory()->create();
        $activite = Activite::factory()->create();

        $validData = [
            'titre' => 'NewTitle',
            'description' => 'NewDiscription',
            'remise' => 15,
            'date_debut_inscription' => '2025-01-01',
            'date_fin_inscription' => '2025-01-31',
            'administrateur_id' => $administrateur->id,
            'paiement_id' => $paiement->id,
            'activites' => [
                ['id' => $activite->id]
            ]
        ];

        $response = $this->putJson("/api/offres/{$offre->id}", $validData);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Offer updated successfully',
            'offer' => [
                'titre' => 'NewTitle',
                'description' => 'NewDiscription',
                'remise' => 15,
                'date_debut_inscription' => '2025-01-01',
                'date_fin_inscription' => '2025-01-31',
                'administrateur_id' => $administrateur->id,
                'paiement_id' => $paiement->id,
                'activites' => [ ['id' => $activite->id]]
            ]
        ]);

        $offre->refresh();

        $this->assertEquals('NewTitle', $offre->titre);
        $this->assertEquals(15, $offre->remise);
        $this->assertEquals($administrateur->id, $offre->administrateur_id);
        $this->assertCount(1, $offre->getActivites());
        $this->assertTrue($offre->getActivites()->first()->id === $activite->id);
    }
}
 

