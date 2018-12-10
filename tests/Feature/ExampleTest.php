<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ExampleTest extends TestCase
{
    use WithoutMiddleware;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

//    public function testCreateTeamTest()
//    {
//        $json = 'Add successful!';
//        $newTeam = [
//            'name' => 'php'
//        ];
//        $table = 'teams';
//        $response = $this->json('POST', route('teams.store'), ['name' => 'php']);
//        $this->assertSame($json, $response->json(['message']));
//        $this->assertDatabaseHas($table, $newTeam);
//        $response->assertSuccessful();
//    }

}
