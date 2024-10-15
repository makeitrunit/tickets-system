<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
    /** @test */
    public function event_can_be_created(): void
    {
        $this->actingAs(User::factory()->create());
        $event = [
            'name' => 'Test Event',
            'description' => 'Test Event Description',
            'qty' => 10,
            'available_qty' => 10,
            'date_from' => Carbon::create(2024, 10, 10),
            'date_until' => Carbon::create(2024, 10, 23),
        ];

        $response = $this->post(route('events.store'), $event);

        $response->assertRedirect(route('events.show', Event::first()->id));

        $this->assertDatabaseHas('events', $event);
    }

    /** @test */
    public function event_cant_be_created_without_name(): void
    {
        $this->actingAs(User::factory()->create());
        $event = [
            'description' => 'Test Event Description',
            'qty' => 10,
            'available_qty' => 10,
            'date_from' => Carbon::create(2024, 10, 10),
            'date_until' => Carbon::create(2024, 10, 23),
        ];

        $response = $this->post(route('events.store'), $event, [
            'X-CSRF-Token' => csrf_token(),
        ]);

        $response->assertRedirect(route('events.create'));

        !$this->assertDatabaseHas('events', $event);
    }


}
