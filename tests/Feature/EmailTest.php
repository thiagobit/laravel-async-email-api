<?php

namespace Tests\Feature;

use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmailTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function authorized_user_can_send_emails()
    {
        $this->actingAs(new User(), 'api');

        $emailPost = rawEmail();

        $this->postJson(route('api.send'), ['emails' => [$emailPost]])->assertSuccessful();
    }

    /** @test */
    public function guests_cannot_send_emails()
    {
        $this->withoutExceptionHandling();

        $this->expectException('Illuminate\Auth\AuthenticationException');

        $emailPost = rawEmail();

        $this->postJson(route('api.send'), ['emails' => [$emailPost]]);
    }
}
