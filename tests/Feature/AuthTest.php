<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTest extends TestCase
{
    use WithFaker;

    protected $expectedJsonStructure = [
        'success',
        'user' => [
            'id',
            'full_name',
            'email',
            'phone',
            'image',
            'thumbnail_image',
        ],
        'access_token',
        'token_type',
    ];
    protected $bearerToken;
    protected $phone = '994516783741';
    protected $password = '12345678';

    /**
     * Test if user can register.
     *
     * @return void
     */
    public function testUserRegistration()
    {
        $errorResponse = '';
        try {
            $this->withoutExceptionHandling();

            $userData = [
                'full_name' => $this->faker->name(),
                'email' => $this->faker->email(),
                'phone' => '994516783741',
                'password' => $this->password,
                'password_confirmation' => $this->password
            ];

            $response = $this->postJson($this->customerUrl('register'), $userData);
            $this->bearerToken = $response->baseResponse->original['access_token'];
            $errorResponse = $response;
            $response->assertJsonStructure($this->expectedJsonStructure)->assertStatus(200);
        } catch (\Exception $e) {
            Log::channel('testing')->error('testUserRegistration response: ' . json_encode($errorResponse));
            throw $e;
        }
    }

    /**
     * Test if user can login.
     *
     * @return void
     */
    public function testUserLogin()
    {
        try {
            $this->withoutExceptionHandling();
            // $user = User::factory()->create();
            // Log::channel('testing')->info("testUserLogin user: " . json_encode($user));
            $this->createUser();

            $userData = [
                'phone' => '994516783741',
                'password' => 'reshad2022',
            ];

            $response = $this->postJson($this->customerUrl('login'), $userData);
            $response->assertJsonStructure($this->expectedJsonStructure)->assertStatus(200);
        } catch (\Exception $e) {
            Log::channel('testing')->error('testUserLogin response: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Test if user can update data.
     *
     * @return void
     */
    public function testUserUpdate()
    {
        try {
            $this->withoutExceptionHandling();
            $image = UploadedFile::fake()->image('test.jpg');
            $user = User::factory()->create();
            $this->actingAs($user, 'customer');
            // $token = JWTAuth::fromUser($user);
            $userData = [
                'phone' => $this->faker->phoneNumber(),
                'email' => $this->faker->email(),
                'full_name' => 'Rashaddd',
                'image' => $image,
                'gender' => 'male',
                'birth_date' => date('Y-m-d')
            ];

            $response = $this->postJson($this->customerUrl('update-profile'), $userData);
            // Log::channel('testing')->error('testUserUpdate bearer token: ' . $token);
            // $response = $this->withHeaders([
            //     'Authorization' => 'Bearer ' . $token,
            // ])->postJson('/api/update-profile', $userData);

            $jsonStructure = ['status', 'message', 'data'];
            $response->assertJsonStructure($jsonStructure)->assertStatus(200);
        } catch (\Exception $e) {
            Log::channel('testing')->error('testUserUpdate response: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Test if user can logout.
     *
     * @return void
     */
    public function testLogout()
    {
        try {
            $this->withoutExceptionHandling();
            $user = User::factory()->create();
            $token = JWTAuth::fromUser($user);
            // Generate a personal access token for the user
            Log::channel('testing')->error('testLogout bearer token: ' . $token);
            $response = $this->withHeaders([
                'Authorization' => "Bearer $token",
                'Device' => 'app'
            ])->postJson($this->customerUrl('logout'));

            Log::info("response" . json_encode($response));

            $response->assertStatus(200);
        } catch (\Exception $e) {
            Log::channel('testing')->error('testLogout response: ' . $e->getMessage());
            throw $e;
        }
    }
}
