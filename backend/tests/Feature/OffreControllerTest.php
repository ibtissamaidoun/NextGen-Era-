<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Offre;
use App\Models\Administrateur;
use App\Models\Paiement;
use App\Models\Activite;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class OffreControllerTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function testDeleteUnsuccessfully()
    {
        $nonExistentId = 999;  // cela veut dire que id n'existe pas
        $response = $this->deleteJson("api/offres/{$nonExistentId}");
        $response->assertStatus(404);
        $response->assertJson(['message' => 'Offre non trouvée']);
    }

    public function testDeleteSuccessfully()
    {
        $administrateur = Administrateur::factory()->create();
        $paiement = Paiement::factory()->create();
        $offre = Offre::factory()->create([
            'administrateur_id' => $administrateur->id,
            'paiement_id' => $paiement->id,
        ]);

        $response = $this->deleteJson("api/offres/{$offre->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('offres', ['id' => $offre->id]);
    }

    public function testStoreInvalidData()
    {
        $response = $this->postJson('/api/offres', [
            'titre' => '',
            'description' => '',
            'date_debut' => '',
            'date_fin' => '',
            'activites' => []
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['titre', 'description', 'date_debut', 'date_fin', 'activites']);
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
            'date_debut' => '2024-01-01',
            'date_fin' => '2024-01-31',
            'paiement_id' => $paiement->id,
            'activites' => [$activite->id]
        ];

        $response = $this->postJson('/api/offres', $validData);
        $response->assertStatus(201);
        $response->assertJson([
            'message' => 'Offer created successfully',
            'offer' => [
                'titre' => 'Nouvelle Offre',
                'description' => 'Description de l\'offre.',
                'remise' => 10,
                'date_debut' => '2024-01-01',
                'date_fin' => '2024-01-31',
                'paiement_id' => $paiement->id,
                'activites' => [$activite->id]
            ]
        ]);

        $this->assertDatabaseHas('offres', [
            'titre' => 'Nouvelle Offre',
            'description' => 'Description de l\'offre.'
        ]);
    }

    public function testUpdateOffreNotFound()
    {
        $response = $this->putJson('/api/offres/999', []);
        $response->assertStatus(404);
    }

    public function testUpdateInvalidData()
    {   $administrateur = Administrateur::factory()->create();
        $paiement = Paiement::factory()->create();
        $offre = Offre::factory()->create();
        $response = $this->putJson("/api/offres/{$offre->id}", [
            'titre' => '',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['titre']);
    }

    public function testUpdateValidData()
    {
        $administrateur = Administrateur::factory()->create();
        $paiement = Paiement::factory()->create();
        $activite = Activite::factory()->create();
        $offre = Offre::factory()->create();
        $validData = [
            'titre' => 'Updated Title',
            'description' => 'Updated Description',
            'remise' => 15,
            'date_debut' => '2025-01-01',
            'date_fin' => '2025-01-31',
            'paiement_id' => $paiement->id,
            'activites' => [$activite->id]
        ];

        $response = $this->putJson("/api/offres/{$offre->id}", $validData);
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Offer updated successfully',
            'offer' => [
                'titre' => 'Updated Title',
                'description' => 'Updated Description',
                'remise' => 15,
                'date_debut' => '2025-01-01',
                'date_fin' => '2025-01-31',
                'paiement_id' => $paiement->id,
                'activites' => [$activite->id]
            ]
        ]);

        $offre->refresh();
        $this->assertEquals('Updated Title', $offre->titre);
        $this->assertEquals('Updated Description', $offre->description);
        $this->assertEquals(15, $offre->remise);
        $this->assertEquals($paiement->id, $offre->paiement_id);
        $this->assertCount(1, $offre->activites);
        $this->assertTrue($offre->activites->first()->id === $activite->id);
    }
}