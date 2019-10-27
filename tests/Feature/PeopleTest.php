<?php

namespace Tests\Feature;

use App\People;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PeopleTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPeople()
    {
        $email = $this->faker->safeEmail;
        $pass = 'testing';

        // register
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/v1/register', [
            'name' => 'John Doe',
            'email' => $email,
            'password' => $pass,
            'c_password' => $pass,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        // login
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/v1/login', [
            'email' => $email,
            'password' => $pass,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $token = $response->decodeResponseJson()['data']['token'];

        // show person
        $person = People::select('name')->first();
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', '/api/v1/people/person', [
            'name' => $person->name,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'name' => $person->name,
                ]
            ]);
    }
}
