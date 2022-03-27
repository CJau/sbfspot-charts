<?php

namespace Tests\Feature;

use App\DayDataPoint;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DayDataPointTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function edit_works_ok()
    {
        $point = DayDataPoint::factory()->create();

        $this->actingAs(User::factory()->create())
            ->get(route('day_data_points.edit', [
                $point->Serial,
                $point->TimeStamp->format('U'),
            ]))
            ->assertOk()
            ->assertViewIs('day_data_points.edit')
            ->assertViewHas([
                'dayDataPoint',
            ]);
    }

    /** @test */
    public function update_saves_and_redirects()
    {
        $update = DayDataPoint::factory()->create();
        $retain = DayDataPoint::factory()->create();

        $this->actingAs(User::factory()->create())
            ->patch(route('day_data_points.edit', [
                $update->Serial,
                $update->TimeStamp->format('U')
            ]), [
                'Power' => 500,
                'TotalYield' => 1500,
            ])
            ->assertRedirect(route('graphs.day', $update->TimeStamp->toDateString()));

        $this->assertTrue(DayDataPoint::where([
            'Serial' => $update->Serial,
            'TimeStamp' => $update->getRawOriginal('TimeStamp'),
            'Power' => 500,
            'TotalYield' => 1500,
        ])->exists());

        $this->assertTrue(DayDataPoint::where([
            'Serial' => $retain->Serial,
            'TimeStamp' => $retain->getRawOriginal('TimeStamp'),
            'Power' => $retain->Power,
            'TotalYield' => $retain->TotalYield,
        ])->exists());
    }
}
