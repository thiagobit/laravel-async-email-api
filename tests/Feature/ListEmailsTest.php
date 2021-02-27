<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ListEmailsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function authorized_user_can_list_emails()
    {
        $this->actingAs(new User(), 'api');

        $emailPost = createEmail();

        // addapting to the format of list route return
        $emailPost['attachments'][0] = ['url' => Storage::disk('public')->url($emailPost['attachments'][0]['name'])];

        $this->getJson(route('api.list'))->assertJson([$emailPost]);
    }

    /** @test */
    public function guests_cannot_list_emails()
    {
        $this->withoutExceptionHandling();

        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->getJson(route('api.list'));
    }
}
