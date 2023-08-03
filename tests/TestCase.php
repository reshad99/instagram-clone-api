<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase, WithFaker;

    protected $headers = [
        'Accept' => 'application/json',
        'Device' => 'app',
    ];

    protected $baseDriverUrl = '/api/driver';
    protected $baseCustomerUrl = '/api/customer';

    protected function useDatabase($connection = 'testing')
    {
        // $database = 'testing';

        // Config::set('database.default', $connection);
        // Config::set('database.connections.' . $connection . '.database', $database);
    }

    public function createUser()
    {
        $image = UploadedFile::fake()->image('test.jpg');
        $userData = [
            'full_name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'phone' => '994516783741',
            'password' => 'reshad2022',
            'password_confirmation' => 'reshad2022'
        ];

        $response = $this->postJson($this->customerUrl('register'), $userData);

        return $userData;
    }

    public function createDriver()
    {
        $image = UploadedFile::fake()->image('test.jpg');
        $driverData = [
            'full_name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'phone' => '994516783741',
            'gender' => 'male',
            'birth_date' => '1999-03-13',
            'password' => 'reshad2022',
            'password_confirmation' => 'reshad2022'
        ];

        $response = $this->postJson('/api/driver/register', $driverData);

        return $driverData;
    }

    public function driverUrl(string $route)
    {
        return $this->baseDriverUrl . '/' . $route;
    }

    public function customerUrl(string $route)
    {
        return $this->baseCustomerUrl . '/' . $route;
    }
}
