<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AddressTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testFavoriteAddresses()
    {

        $user = User::factory()->create();
        $this->actingAs($user, 'customer');
        $response = $this->getJson($this->customerUrl('favorite-addresses'));
        $jsonStructure = ['status', 'count', 'data'];

        $response->assertStatus(200);
    }
}
