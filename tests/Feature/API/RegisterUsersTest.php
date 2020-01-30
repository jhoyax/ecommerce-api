<?php

namespace Tests\Feature\API;

use Illuminate\Http\Response;
use Tests\TestCaseAPI;
use Tests\Traits\RefreshDatabaseWithSeeds;

class RegisterUsersTest extends TestCaseAPI
{
    use RefreshDatabaseWithSeeds;

    /**
     * Successful User Registration
     *
     * @return void
     */
    public function testSuccessfulUserRegistration()
    {
        $data = [
            'name' => 'Juan Dela Cruz',
            'email' => 'juan_dela_cruz@ligph.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->postJson($this->path('register'), $data)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ]
            ]);;
    }

    /**
     * Failed User Registration
     *
     * @return void
     */
    public function testFailedUserRegistration()
    {
        $data = [];

        $this->postJson($this->path('register'), $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'message',
                'errors',
            ]);
    }
}
