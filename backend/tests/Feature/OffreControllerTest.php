<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Offre;
use App\Models\Activite;
use App\Models\Paiement;
use App\Models\Administrateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class OffreControllerTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function testDeleteUnsuccessfully()
    {
        $nonExistentId = 999;
        $response = $this->deleteJson("/api/dashboard-admin/offres/{$nonExistentId}");
        $response->assertStatus(404);
        $response->assertJson(['message' => 'Offre non trouvée']);
    }

    public function testDeleteSuccessfully()
    {
        $user = User::factory()->create();
        $administrateur = Administrateur::factory()->create(['user_id' => $user->id]);
        $paiement = Paiement::factory()->create();
        $offre = Offre::factory()->create([
            'administrateur_id' => $administrateur->id,
            'paiement_id' => $paiement->id,
        ]);

        $response = $this->actingAs($user)->deleteJson("/api/dashboard-admin/offres/{$offre->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('offres', ['id' => $offre->id]);
    }

    public function testStoreInvalidData()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson('/api/dashboard-admin/offres', [
            'titre' => '',
            'description' => '',
            'date_debut' => '',
            'date_fin' => '',
            'paiement_id' => '',
            'activites' => []
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['titre', 'description', 'date_debut', 'date_fin', 'paiement_id', 'activites']);
    }

    public function testStoreValidData()
{
    $user = User::factory()->create();
    $administrateur = Administrateur::factory()->create(['user_id' => $user->id]);
    $paiement = Paiement::factory()->create();
    $activite = Activite::factory()->create();

    $validData = [
        'titre' => 'Nouvelle Offre',
        'description' => 'Description de l\'offre.',
        'remise' => 10,
        'date_debut' => '2024-01-01',
        'date_fin' => '2024-01-31',
        'paiement_id' => $paiement->id,
        'activites' => [['id' => $activite->id]]
    ];

    $response = $this->actingAs($user)->postJson('/api/dashboard-admin/offres/', $validData);
    dump($response);
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
            'administrateur_id' => $administrateur->id,
            'activites' => [['id' => $activite->id]]
        ]
    ]);

    $this->assertDatabaseHas('offres', [
        'titre' => 'Nouvelle Offre',
        'description' => 'Description de l\'offre.'
    ]);
}

    public function testUpdateOffreNotFound()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->putJson('/api/dashboard-admin/offres/999', []);
        $response->assertStatus(404);
    }

    public function testUpdateInvalidData()
    {
        $user = User::factory()->create();
        $administrateur = Administrateur::factory()->create(['user_id' => $user->id]);
        $paiement = Paiement::factory()->create();
        $offre = Offre::factory()->create([
            'administrateur_id' => $administrateur->id,
            'paiement_id' => $paiement->id,
        ]);

        $response = $this->actingAs($user)->putJson("/api/dashboard-admin/offres/{$offre->id}", [
            'titre' => 123,
            'description' => 456,
            'date_debut' => 'invalid-date',
            'date_fin' => 'invalid-date',
            'paiement_id' => 99999,
            'remise' => 'test',
            'activites' => [
                ['id' => 'invalid-id']

                ]

    ]);



        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'titre',
            'description',
            'date_debut',
            'date_fin',
            'paiement_id',
            'remise',
            'activites.0.id'
        ]);
    }
    public function testUpdateValidData()
    {
        $user = User::factory()->create();
        $administrateur = Administrateur::factory()->create(['user_id' => $user->id]);
        $paiement = Paiement::factory()->create();
        $activite = Activite::factory()->create();
        $offre = Offre::factory()->create([
            'administrateur_id' => $administrateur->id,
            'paiement_id' => $paiement->id,
        ]);

        $validData = [
            'titre' => 'Updated Title',
            'description' => 'Updated Description',
            'remise' => 15,
            'date_debut' => '2025-01-01',
            'date_fin' => '2025-01-31',
            'paiement_id' => $paiement->id,
            'activites' => [['id' => $activite->id]]
        ];

        $response = $this->actingAs($user)->putJson("/api/dashboard-admin/offres/{$offre->id}", $validData);
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Offer updated successfully',
            'offer' => [
                'id' => $offre->id,
                'titre' => 'Updated Title',
                'description' => 'Updated Description',
                'remise' => 15,
                'date_debut' => '2025-01-01',
                'date_fin' => '2025-01-31',
                'paiement_id' => $paiement->id,
                'administrateur_id' => $administrateur->id,
                'created_at' => $offre->created_at->toISOString(),
                'updated_at' => $offre->updated_at->toISOString(),
            ]
        ]);

        $offre->refresh();
        $this->assertEquals('Updated Title', $offre->titre);
        $this->assertEquals('Updated Description', $offre->description);
        $this->assertEquals(15, $offre->remise);
        $this->assertEquals($paiement->id, $offre->paiement_id);
        $this->assertEquals($administrateur->id, $offre->administrateur_id);
    }
}
