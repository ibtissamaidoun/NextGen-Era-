<?php

namespace Tests\Feature;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthControllerTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $nom = "test";
        $prenom = "testtesting";
        $telephone_portable = "0657489345";
        $telephone_fixe = "0567834567";
        $email = "test1111@gmail.com";
        $mot_de_passe = "testing";

        $response = $this->post('/api/register', [
            'nom'=>$nom,
            'prenom'=>$prenom,
            'telephone_portable' => $telephone_portable,
            'telephone_fixe' => $telephone_fixe,
            'email' => $email,
            'role' => 'parent',
            'mot_de_passe' => $mot_de_passe,
            'mot_de_passe_confirmation' => $mot_de_passe,
        ]);

    }
    public function testauthRegistrationTrue()
    {

        $nom = "test";
        $prenom = "testtesting";
        $telephone_portable = "0657489345";
        $telephone_fixe = "0567834567";
        $email = "test11119@gmail.com";
        $mot_de_passe = "testing";
        $fonction = 'Enseignant';

        $response = $this->post('/api/register', [
            'nom'=>$nom,
            'prenom'=>$prenom,
            'telephone_portable' => $telephone_portable,
            'telephone_fixe' => $telephone_fixe,
            'email' => $email,
            'role' => 'parent',
            'mot_de_passe' => $mot_de_passe,
            'mot_de_passe_confirmation' => $mot_de_passe,
            'fonction' => $fonction,
        ]);

        $response->assertStatus(202);

        $this->assertDatabaseHas('users', [
            'nom'=>$nom,
            'prenom'=>$prenom,
            'telephone_portable' => $telephone_portable,
            'telephone_fixe' => $telephone_fixe,
            'email' => $email,
            'role' => 'parent',
        ]);
        $user = User::where('email', $email)->first();
        $this->assertDatabaseHas('parentmodels', [
            'fonction' => $fonction,
            'user_id' => $user->id
        ]);

        $response->assertJsonStructure([
            'token',
            'refresh_token',
        ]);

        $this->assertNotEmpty($response['token']);
    }
    public function testregistrationFalse()
    {

        $response = $this->postJson('/api/register', []);

        $response->assertStatus(500)
            ->assertJson(['status' => false]);
    }
    public function testAuthLoginTrue()
    {
        $email = "test1111@gmail.com";
        $mot_de_passe = "testing";

        $response = $this->post('/api/login', [
            'email' => $email,
            'mot_de_passe' => $mot_de_passe,
        ]);

        $response->assertStatus(202);

        $response->assertJsonStructure([
            'role',
            'token',
            'refresh_token'
        ]);

        $this->assertNotEmpty($response['token']);
    }
    public function testAuthLoginMotDePasseFalse()
    {

        $email = "test1111@gmail.com";
        $mot_de_passe= "falsetesting";

        $response = $this->post('/api/login', [
            'email' => $email,
            'mot_de_passe' => $mot_de_passe,
        ]);

        $response->assertStatus(401);

    }

    public function testAuthLoginEmailFalse()
    {

        $email = "falsetest1111@gmail.com";
        $mot_de_passe = "testing";

        $response = $this->post('/api/login', [
            'email' => $email,
            'mot_de_passe' => $mot_de_passe,
        ]);

        $response->assertStatus(401);
    }
    public function testLogout()
    {
        $email = "test1111@gmail.com";
        $mot_de_passe = "testing";
        $response = $this->post('/api/login', [
            'email' => $email,
            'mot_de_passe' => $mot_de_passe,
        ]);

        $response->assertStatus(202);
        $responseData = $response->json();
        $token = $responseData['token'];
        $refresh_token = $responseData['refresh_token'];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token, 'Refresh-Token' => $refresh_token,
        ])->post('/api/logout');
        $response->assertStatus(200)
            ->assertExactJson(['message' => 'Logged out successfully']);

    }

    public function tearDown(): void
    {
        $this->artisan('migrate:rollback');
        parent::tearDown();
    }
}
