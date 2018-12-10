<?php

namespace Tests\Unit;

use Faker\Factory;
use Illuminate\Support\Facades\App;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Team;

class TeamControllerTest extends TestCase
{
    use WithoutMiddleware;
    use RefreshDatabase;
    const TABLE_NAME = 'teams';
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateTeamTest()
    {
        $message = config('api.create');
        $newTeam = [
            'name' => 'php'
        ];
        $response = $this->json('POST', route('teams.store'), $newTeam);
        $this->assertSame($message, $response->json(['message']));
        $this->assertDatabaseHas(self::TABLE_NAME, $newTeam);
        $response->assertSuccessful();
    }

    public function testUpdateTeamTest()
    {
        $array = factory(Team::class)->create();
        $updateTeam = [
            'name' => 'ruby on rail',
        ];
        $response = $this->json('PUT', route('teams.update', $array['id']), $updateTeam);
        $this->assertDatabaseHas(self::TABLE_NAME, $updateTeam);
        $response->assertSuccessful();
    }

    public function testDeleteTeamTest()
    {
        $array = factory(Team::class)->create();
        $response = $this->call('DELETE', route('teams.destroy', $array['id']));
        $this->assertDatabaseMissing(self::TABLE_NAME, $array->toArray());
        $response->assertSuccessful();
    }

    public function testCreateTeamValidateUniqueTest()
    {
        $array = factory(Team::class)->create();
        $response = $this->json('POST', route('teams.store'), $array->toArray());
        $this->assertSame('The given data was invalid.', $response->json(['message']));
    }

}
