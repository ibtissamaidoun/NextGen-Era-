<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\UserController;
use app\Http\Controllers\ForgotController;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ForgetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;




class ForgotControllerTest extends TestCase
{
    use RefreshDatabase;


    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
        Notification::fake();

    }

     public function test_valid_email_and_exist_dans_DB()
    {
        $user = User::factory()->create(['email' => 'testtesting@gmail.com']);
        $response = $this->postJson('/api/forget', ['email' => 'testtesting@gmail.com']);
        $response->assertStatus(202)
                ->assertJson(['message' => 'Reset link sent to your email address']);

        Notification::assertSentTo(
            [$user],
            ForgetPasswordNotification::class,
            function ($notification, $channels) use ($user) {
                $token = DB::table('password_reset_tokens')->where('email', $user->email)->first()->token;
                return $notification->token === $token;
            }
        );
        $tokenFromDB = DB::table('password_reset_tokens')->where('email', 'testtesting@gmail.com')->first()->token;
        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => 'testtesting@gmail.com',
            'token' => $tokenFromDB
        ]);
    }

    public function test_invalid_email()
    {
        $response = $this->postJson('/api/forget', ['email' => 'test_testing']);

        $response->assertStatus(500);

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

        $response->assertStatus(500);
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

        $response->assertStatus(500);
    }


}
