<?php
namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use app\Http\Controllers\ForgotController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;




class ForgotControllerTest extends TestCase
{
    use RefreshDatabase;


    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();

    }

     public function test_valid_email_and_exist_dans_DB()
    {
        $user = User::factory()->create(['email' => 'testtesting@gmail.com']);
        $response = $this->postJson('/api/forget', ['email' => 'testtesting@gmail.com']);
        $response->assertStatus(202)
                 ->assertJson(['message' => 'Reset link sent to your email address'])
                 ->assertJsonStructure(['token']);
        Mail::assertSent(\Illuminate\Mail\Message::class, function ($mail) use ($user) {
            $subject = $mail->getSwiftMessage()->getSubject();
            return $mail->hasTo($user->email) && $subject === 'Reset your password';
        });


        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => 'testtesting@gmail.com',
            'token' => $response->json('token')
        ]);
    }

    public function test_invalid_email()
    {
        $response = $this->postJson('/api/forget', ['email' => 'test_testing']);

        $response->assertStatus(422);

        //Mail::assertNotSent();
    }

    public function test_valid_email_but_not_exist_dans_DB()
    {
        $response = $this->postJson('/api/forget', ['email' => 'falsetesttesting@gmail.com']);

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Email not found']);

        //Mail::assertNotSent();
    }

    public function test_reset_Mot_de_passe_confirmation_invalid()
    {
        $user = User::factory()->create(['email' => 'testtesting11@gmail.com']);
        $token = Str::random(60);
        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now()
        ]);

        $response = $this->postJson('/api/reset', [
            'mot_de_passe' => 'testtesting11',
            'mot_de_passe_confirmation' => 'falsetesttesting11',
            'token' => $token
        ]);

        $response->assertStatus(422);
    }

    public function test_reset_invalid_token()
    {
        $response = $this->postJson('/api/reset', [
            'mot_de_passe' => 'testtesting11',
            'mot_de_passe_confirmation' => 'testtesting11',
            'token' => 'falsetoken'
        ]);

        $response->assertStatus(404)
                 ->assertJson(['message' => 'invalid token']);
    }


    public function test_reset_successfully()
    {
        $user = User::factory()->create(['email' => 'testtesting111@gmail.com']);
        $token = Str::random(60);
        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now()
        ]);

        $response = $this->postJson('/api/reset', [
            'mot_de_passe' => 'testtesting111',
            'mot_de_passe_confirmation' => 'testtesting111',
            'token' => $token
        ]);

        $response->assertStatus(202)
                 ->assertJson(['message' => 'Your password is reset successfully']);

        $this->assertTrue(Hash::check('testtesting111', $user->fresh()->mot_de_passe));
        $this->assertDatabaseMissing('password_reset_tokens', ['token' => $token]);
    }


    public function test_reset_password_invalid()
    {
        $user = User::factory()->create(['email' => 'testtesting1111@gmail.com']);
        $token = Str::random(60);
        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now()
        ]);

        $response = $this->postJson('/api/reset', [
            'mot_de_passe' => '',
            'mot_de_passe_confirmation' => '',
            'token' => $token
        ]);

        $response->assertStatus(422);
    }


}
