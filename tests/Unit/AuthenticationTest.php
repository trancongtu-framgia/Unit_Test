<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Middleware\Authenticate;
use Illuminate\Auth\AuthenticationException;
use App\User;

class AuthenticationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testMiddlewareTest()
    {
        $newteam = [
            'name' => 'python'
        ];
        $response = $this->json('POST', route('teams.store'), $newteam);
        $this->assertSame('Unauthenticated.', $response->json(['message']));
        $response->assertJson(['message' => 'Unauthenticated.']);
    }

    public function testHandleUnauthorizedTest()
    {
        $middleware = new Authenticate($this->app['auth']);
        $this->expectException(AuthenticationException::class);
        $middleware->handle($this->app['request'], function () {});
    }

    public function testHandleAuthorizedTest()
    {
        $middleware = new Authenticate($this->app['auth']);
        $user = factory(User::class)->create();
        $use = $this->actingAs($user);
        $this->assertNull($middleware->handle($this->app['request'], function () {}));
    }
}
