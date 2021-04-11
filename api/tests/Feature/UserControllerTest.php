<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index()
    {
        $this->dataFaker('create', User::class, $total = 20);

        $response = $this->json("GET", route('user.index'));

        $response
            ->assertOk()
            ->assertJsonPath('meta.total', $total);
    }

    /**
     * @test
     */
    public function store()
    {
        $userFake = $this->dataFaker('make', User::class);

        $response = $this->json("POST", route('user.store'), $userFake->getAttributes());

        $response->assertCreated();
    }

    /**
     * @test
     */
    public function show()
    {
        $user = $this->dataFaker('create', User::class);
        $response = $this->json("GET", route('user.show', $user));

        $response
            ->assertOk()
            ->assertJsonPath('data.name', $user->name);
        $this->assertDatabaseHas('users', $user->getAttributes());
    }

    /**
     * @test
     */
    public function update()
    {
        $user = $this->dataFaker('create', User::class);
        $userFake = $this->dataFaker('make', User::class);

        $response = $this->json("PUT", route('user.update', $user), $userFake->toArray());
        $response
            ->assertOk()
            ->assertJsonPath('data.name', $userFake->name);

    }

    /**
     * @test
     */
    public function destroy()
    {
        $user = $this->dataFaker('create', User::class);

        $response = $this->json("DELETE", route('user.destroy', $user));
        $response
            ->assertNoContent();
        $this->assertDatabaseMissing('users', $user->getAttributes());

    }
}
