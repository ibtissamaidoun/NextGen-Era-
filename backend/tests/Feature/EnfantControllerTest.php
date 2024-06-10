<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Parentmodel;
use App\Models\Enfant;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

class EnfantControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreDataInvalid()
    {
        $user = User::factory()->create(['role' => 'parent']);
        $parent = Parentmodel::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->postJson("/api/parent/enfants", [
            'nom' => 123,
            'prenom' => 123,
            'date_de_naissance' => 'testNotDate',
            'niveau_etude' => 'Universitaire',
            'parentmodel_id' => ''
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'nom',
            'prenom',
            'date_de_naissance',
            'niveau_etude'
        ]);
    }

    public function testStoreDataValideUserNonAuthentifier()
    {
        $response = $this->postJson('/api/parent/enfants', [
            'nom' => 'test',
            'prenom' => 'testtesting',
            'date_de_naissance' => '2010-04-01',
            'niveau_etude' => 'Primaire'
        ]);

        $response->assertUnauthorized();
    }

    public function testStoreDataValideUserAuthentifierEnfantExiste()
    {
        $user = User::factory()->create(['role' => 'parent']);
        $parent = Parentmodel::factory()->create(['user_id' => $user->id]);
        $child = Enfant::factory()->create([
            'nom' => 'test99',
            'prenom' => 'testtesting99',
            'parentmodel_id' => $parent->id
        ]);

        $response = $this->actingAs($user)->postJson('/api/parent/enfants', [
            'nom' => 'test99',
            'prenom' => 'testtesting99',
            'date_de_naissance' => '2010-04-01',
            'niveau_etude' => 'Primaire'
        ]);

        $response->assertStatus(422);
        $response->assertJson(['message' => 'Un enfant avec ces informations existe déjà']);
    }

    public function testUpdateDataInvalid()
    {
        $user = User::factory()->create(['role' => 'parent']);
        $parent = Parentmodel::factory()->create(['user_id' => $user->id]);
        $enfant = Enfant::factory()->create(['parentmodel_id' => $parent->id]);

        $response = $this->actingAs($user)->putJson("/api/parent/enfants/{$enfant->id}", [
            'nom' => 1234,
            'prenom' => 123456,
            'date_de_naissance' => 'NotDate',
            'niveau_etude' => 'Universitaire'
        ]);

        // Log the response content for debugging
        error_log($response->getContent());

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nom', 'prenom', 'date_de_naissance', 'niveau_etude']);
    }

    public function testUpdateValideDataUserAuthentifierEnfantNonExiste()
    {
        $user = User::factory()->create(['role' => 'parent']);
        $parent = Parentmodel::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->putJson("/api/parent/enfants/99999", [
            'nom' => 'testNotExistnom',
            'prenom' => 'testNotExistprenom',
            'date_de_naissance' => now()->subYears(10)->toDateString(),
            'niveau_etude' => 'College'
        ]);

        // Log the response content for debugging
        error_log($response->getContent());

        $response->assertStatus(403);
        $response->assertJson(['message' => 'enfant non existant.']);
    }

    public function testUpdateValideDataUserAuthentifierEnfantExisteSansConflit()
    {
        $user = User::factory()->create(['role' => 'parent']);
        $parent = Parentmodel::factory()->create(['user_id' => $user->id]);
        $enfant = Enfant::factory()->create(['parentmodel_id' => $parent->id, 'nom' => 'testFirst']);

        $response = $this->actingAs($user)->putJson("/api/parent/enfants/{$enfant->id}", [
            'nom' => 'testsecond',
            'prenom' => 'testsecond',
            'date_de_naissance' => '2010-04-01',
            'niveau_etude' => 'Primaire'
        ]);

        // Log the response content for debugging
        error_log($response->getContent());

        $response->assertSuccessful();
        $response->assertJson([
            'message' => 'modification avec succes.',
            'enfant' => [
                'nom' => 'testsecond',
                'prenom' => 'testsecond'
            ]
        ]);
        $this->assertDatabaseHas('enfants', [
            'id' => $enfant->id,
            'nom' => 'testsecond'
        ]);
    }

    public function testUpdateValideDataUserAuthentifierEnfantExisteAvecConflit()
    {
        $user = User::factory()->create(['role' => 'parent']);
        $parent = Parentmodel::factory()->create(['user_id' => $user->id]);
        $enfant1 = Enfant::factory()->create([
            'parentmodel_id' => $parent->id,
            'nom' => 'testFirst',
            'prenom' => 'UniquePrenom1',
            'date_de_naissance' => '2010-04-01',
            'niveau_etude' => 'Primaire'
        ]);

        $enfant2 = Enfant::factory()->create([
            'parentmodel_id' => $parent->id,
            'nom' => 'testConflit',
            'prenom' => 'UniquePrenom2',
            'date_de_naissance' => '2010-04-01',
            'niveau_etude' => 'Primaire'
        ]);

        $response = $this->actingAs($user)->putJson("/api/parent/enfants/{$enfant1->id}", [
            'nom' => 'testConflit',
            'prenom' => 'UniquePrenom2',
            'date_de_naissance' => '2010-04-01',
            'niveau_etude' => 'Primaire'
        ]);

        // Log the response content for debugging
        error_log($response->getContent());

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'la modification du enfant va creer de occurence'
        ]);
    }
}
