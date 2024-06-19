<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\ParentModel;
use App\Models\Activite;
use App\Models\Enfant;
use App\Models\Administrateur;

class DeviControllerTest extends TestCase
{
    // use RefreshDatabase;

    // /** @test */
    // public function it_modifies_the_panier_successfully()
    // {
    //     // Create a user, parent, administrateur, activite, and enfant
    //     $user = User::factory()->create(['role' => User::ROLE_PARENT]);
    //     $parent = ParentModel::factory()->create(['user_id' => $user->id]);
    //     $administrateur = Administrateur::factory()->create();
    //     $activite = Activite::factory()->create(['administrateur_id' => $administrateur->id]);
    //     $enfant = Enfant::factory()->create(['parentmodel_id' => $parent->id]);

    //     // Attach enfant to activite with a valid status
    //     $activite->enfantsPanier()->attach($enfant->id, ['parentmodel_id' => $parent->id, 'status' => 'valid']);

    //     // Act as the authenticated user
    //     $this->actingAs($user);

    //     // Data to modify the panier
    //     $data = [
    //         'enfant' => $enfant->id,
    //     ];

    //     // Call the modifyPanier method
    //     $response = $this->putJson("/api/parent/panier/activite/{$activite->id}/enfants/{$enfant->id}", $data);

    //     // Assert the response is successful
    //     $response->assertStatus(200)
    //              ->assertJson([
    //                  'message' => 'Panier Modifier avec succes',
    //              ]);
    // }

    // /** @test */
    // public function it_returns_error_if_enfant_or_activite_not_exist()
    // {
    //     $user = User::factory()->create(['role' => User::ROLE_PARENT]);
    //     $parent = ParentModel::factory()->create(['user_id' => $user->id]);

    //     $this->actingAs($user);

    //     $data = [
    //         'enfant' => 9999, // non-existent enfant
    //     ];

    //     $response = $this->putJson("/api/parent/panier/activite/9999/enfants/9999", $data);

    //     $response->assertStatus(422)
    //              ->assertJson([
    //                  'Error' => 'enfant non existant ou activité non existant',
    //              ]);
    // }

    // /** @test */
    // public function it_returns_error_if_enfant_already_exists_in_activite()
    // {
    //     $user = User::factory()->create(['role' => User::ROLE_PARENT]);
    //     $parent = ParentModel::factory()->create(['user_id' => $user->id]);
    //     $administrateur = Administrateur::factory()->create();
    //     $activite = Activite::factory()->create(['administrateur_id' => $administrateur->id]);
    //     $enfant1 = Enfant::factory()->create(['parentmodel_id' => $parent->id]);
    //     $enfant2 = Enfant::factory()->create(['parentmodel_id' => $parent->id]);

    //     $activite->enfantsPanier()->attach($enfant1->id, ['parentmodel_id' => $parent->id, 'status' => 'valid']);
    //     $activite->enfantsPanier()->attach($enfant2->id, ['parentmodel_id' => $parent->id, 'status' => 'valid']);

    //     $this->actingAs($user);

    //     $data = [
    //         'enfant' => $enfant2->id,
    //     ];

    //     $response = $this->putJson("/api/parent/panier/activite/{$activite->id}/enfants/{$enfant1->id}", $data);

    //     $response->assertStatus(422)
    //              ->assertJson([
    //                  'Error' => 'enfant deja existant, dans cette activité',
    //              ]);
    // }
}
