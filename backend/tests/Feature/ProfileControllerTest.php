<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Animateur;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfileControllerTest extends TestCase
{
 use RefreshDatabase, WithFaker;

private $animateur;
 private $animateurProfile;

 protected function setUp(): void
 {
    parent::setUp();
    $this->animateur = User::factory()->create(['role' => 'animateur']);
    $this->animateurProfile = Animateur::factory()->create(['user_id' => $this->animateur->id]);
 }

public function testUserNotFound()
 {
    $response = $this->actingAs($this->animateur)->putJson('/api/animateur/profile/999', []);

    $response->assertStatus(409);
 }

 public function testDataNotValid()
 {
$response = $this->actingAs($this->animateur)->putJson("/api/animateur/profile/{$this->animateur->id}", [
    'email' => 'invalidemail'
 ]);

 $response->assertStatus(409);
}

 public function testUpdateExistentAnimateurHasDomaineCompetence()
 {
    $data = [
        'nom' => 'testAnimateur',
      'prenom' => 'testtestingAnimateur',
      'email' => 'testAnimateur@gmail.com',
       'telephone_portable' => '0618764678',
         'telephone_fixe' => '0529875789',
      'domaine_competence' => 'Informatique'
    ];

    $response = $this->actingAs($this->animateur)->putJson("/api/animateur/profile/{$this->animateur->id}", $data);

    $response->assertStatus(200);
    $response->assertJson([
    'message' => 'Animateur updated successfully'
   ]);

     $this->assertDatabaseHas('users', [
        'id' => $this->animateur->id,
        'email' => 'testAnimateur@gmail.com',
    ]);

    $this->assertDatabaseHas('animateurs', [
       'user_id' => $this->animateur->id,
        'domaine_competence' => 'Informatique'
     ]);
}

public function testUpdateExistentAnimateurWithoutDomaineCompetence()
 {
     $data = [
       'nom' => 'testAnimateur',
         'prenom' => 'testtestingAnimateur',
    'email' => 'testAnimateur@gmail.com',
       'telephone_portable' => '0618764678',
        'telephone_fixe' => '0529875789'
   ];

   $response = $this->actingAs($this->animateur)->putJson("/api/animateur/profile/{$this->animateur->id}", $data);

    $response->assertStatus(200);
   $response->assertJson([
        'message' => 'Animateur updated successfully'
   ]);

  $this->assertDatabaseHas('users', [
        'id' => $this->animateur->id,
       'email' => 'testAnimateur@gmail.com'
    ]);

    $this->assertDatabaseHas('animateurs', [
        'user_id' => $this->animateur->id,
      'domaine_competence' => $this->animateurProfile->domaine_competence
     ]);
 }

}
