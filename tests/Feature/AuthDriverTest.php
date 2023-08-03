<?php

namespace Tests\Feature;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthDriverTest extends TestCase
{
    use WithFaker;

    protected $expectedJsonStructure = [
        'success',
        'driver' => [
            'full_name',
            'phone',
            'email',
            'image',
            'park',
            'passport',
            'driver_license',
        ],
        'access_token',
        'token_type',
    ];
    protected $bearerToken;
    protected $phone = '994516783741';
    protected $password = '12345678';

    /**
     * Test if driver can register.
     *
     * @return void
     */
    public function testDriverRegistration()
    {
        $errorResponse = '';
        try {
            $this->withoutExceptionHandling();

            $driverData = [
                'full_name' => $this->faker->name(),
                'email' => $this->faker->email(),
                'gender' => 'male',
                'birth_date' => '1999-03-13',
                'phone' => '994516783741',
                'password' => $this->password,
                'password_confirmation' => $this->password
            ];

            $response = $this->postJson($this->driverUrl('register'), $driverData);
            $this->bearerToken = $response->baseResponse->original['access_token'];
            $errorResponse = $response;
            $response->assertJsonStructure($this->expectedJsonStructure)->assertStatus(200);
        } catch (\Exception $e) {
            Log::channel('testing')->error('testDriverRegistration response: ' . json_encode($errorResponse));
            throw $e;
        }
    }

    /**
     * Test if driver can login.
     *
     * @return void
     */
    public function testDriverLogin()
    {
        try {
            $this->withoutExceptionHandling();
            // $user = User::factory()->create();
            // Log::channel('testing')->info("testUserLogin user: " . json_encode($user));
            $this->createDriver();

            $driverData = [
                'phone' => '994516783741',
                'password' => 'reshad2022',
            ];

            $response = $this->postJson($this->driverUrl('login'), $driverData);
            $response->assertJsonStructure($this->expectedJsonStructure)->assertStatus(200);
        } catch (\Exception $e) {
            Log::channel('testing')->error('testUserLogin response: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Test if driver can update data.
     *
     * @return void
     */
    public function testDriverUpdate()
    {
        try {
            $this->withoutExceptionHandling();
            $image = UploadedFile::fake()->image('test.jpg');
            $driver = Driver::factory()->create();
            $this->actingAs($driver, 'driver');
            // $token = JWTAuth::fromUser($user);
            $userData = [
                'phone' => $this->faker->phoneNumber(),
                'email' => $this->faker->email(),
                'full_name' => 'Rashaddd',
                'image' => $image,
                'gender' => 'male',
                'birth_date' => date('Y-m-d')
            ];

            $response = $this->postJson($this->driverUrl('update-profile'), $userData);
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
            $driver = Driver::factory()->create();
            $token = JWTAuth::fromUser($driver);
            // Generate a personal access token for the user
            Log::channel('testing')->error('testLogout bearer token: ' . $token);
            $response = $this->withHeaders([
                'Authorization' => "Bearer $token",
                'Device' => 'app'
            ])->postJson($this->driverUrl('logout'));

            Log::info("response" . json_encode($response));

            $response->assertStatus(200);
        } catch (\Exception $e) {
            Log::channel('testing')->error('testLogout response: ' . $e->getMessage());
            throw $e;
        }
    }
}
