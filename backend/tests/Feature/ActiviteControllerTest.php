<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\ActiviteController;
use App\Models\User;
use App\Models\Activite;
use App\Models\administrateur;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ActiviteControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test invalid data for the store method.
     *
     * @return void
     */
    /* public function test_store_with_invalid_data()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        // Prepare invalid data
        $invalidData = [
            'titre' => '',
            'description' => '',
            'objectifs' => '',
            'image_pub' => '',
            'lien_youtube' => '',
            'type_activite' => '',
            'domaine_activite' => '',
            'nbr_seances_semaine' => '',
            'tarif' => '',
            'effectif_min' => '',
            'effectif_max' => '',
            'effectif_actuel' => '',
            'age_min' => '',
            'age_max' => '',
            'option_paiement' => '',
            'remise' => '',
            'date_debut_etud' => '',
            'date_fin_etud' => '',
        ];

        // Send POST request with invalid data
        $response = $this->postJson('/api/activites', $invalidData);

        // Assert validation errors
        $response->assertStatus(422)
                 ->assertJsonValidationErrors([
                     'titre', 'description', 'objectifs', 'image_pub', 'lien_youtube',
                     'type_activite', 'domaine_activite', 'nbr_seances_semaine',
                     'tarif', 'effectif_min', 'effectif_max', 'effectif_actuel',
                     'age_min', 'age_max', 'option_paiement', 'remise',
                     'date_debut_etud', 'date_fin_etud'
                 ]);
    } */

    /**
     * Test valid data and activity created successfully.
     *
     * @return void
     */
    /* public function test_store_with_valid_data_and_successful_creation()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        // Mock storage
        Storage::fake('public');

        // Prepare valid data
        $validData = [
            'titre' => 'Test Activity',
            'description' => 'This is a test description.',
            'objectifs' => 'Test objectives.',
            'image_pub' => UploadedFile::fake()->image('test_image.jpg'),
            'fiche_pdf' => UploadedFile::fake()->create('test_file.pdf', 1024),
            'lien_youtube' => 'https://youtube.com/test',
            'type_activite' => 'Test Type',
            'domaine_activite' => 'Test Domaine',
            'nbr_seances_semaine' => 3,
            'tarif' => 100,
            'effectif_min' => 5,
            'effectif_max' => 20,
            'effectif_actuel' => 5,
            'age_min' => 10,
            'age_max' => 18,
            'option_paiement' => [1, 2],
            'remise' => [10, 20],
            'date_debut_etud' => '2024-06-01',
            'date_fin_etud' => '2024-07-01',
        ];

        // Send POST request with valid data
        $response = $this->postJson('/api/activites', $validData);

        // Assert activity created successfully
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'message',
                     'activity' => [
                         'id', 'titre', 'description', 'objectifs', 'image_pub', 'fiche_pdf',
                         'lien_youtube', 'type_activite', 'domaine_activite', 'nbr_seances_semaine',
                         'tarif', 'effectif_min', 'effectif_max', 'effectif_actuel',
                         'age_min', 'age_max', 'date_debut_etud', 'date_fin_etud',
                         'created_at', 'updated_at'
                     ]
                 ]);

        // Assert the image and PDF are stored
        Storage::disk('public')->assertExists('images/' . $validData['image_pub']->hashName());
        Storage::disk('public')->assertExists('pdfs/' . $validData['fiche_pdf']->hashName());
    }
 */
    /**
     * Test valid data but activity creation fails.
     *
     * @return void
     */
    /* public function test_store_with_valid_data_and_creation_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        // Mock storage
        Storage::fake('public');

        // Prepare valid data
        $validData = [
            'titre' => 'Test Activity',
            'description' => 'This is a test description.',
            'objectifs' => 'Test objectives.',
            'image_pub' => UploadedFile::fake()->image('test_image.jpg'),
            'fiche_pdf' => UploadedFile::fake()->create('test_file.pdf', 1024),
            'lien_youtube' => 'https://youtube.com/test',
            'type_activite' => 'Test Type',
            'domaine_activite' => 'Test Domaine',
            'nbr_seances_semaine' => 3,
            'tarif' => 100,
            'effectif_min' => 5,
            'effectif_max' => 20,
            'effectif_actuel' => 5,
            'age_min' => 10,
            'age_max' => 18,
            'option_paiement' => [1, 2],
            'remise' => [10, 20],
            'date_debut_etud' => '2024-06-01',
            'date_fin_etud' => '2024-07-01',
        ];

        // Simulate database failure
        Activite::shouldReceive('create')->andThrow(new \Exception('Database error'));

        // Send POST request with valid data
        $response = $this->postJson('/api/activites', $validData);

        // Assert the failure response
        $response->assertStatus(500)
                 ->assertJson([
                     'message' => 'Failed to create activity: Database error'
                 ]);

        // Assert the image and PDF are not stored
        Storage::disk('public')->assertMissing('images/' . $validData['image_pub']->hashName());
        Storage::disk('public')->assertMissing('pdfs/' . $validData['fiche_pdf']->hashName());
    } */

}

