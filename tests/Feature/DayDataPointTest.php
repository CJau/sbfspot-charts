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
        $point = factory(DayDataPoint::class)->create();

        $this->actingAs(factory(User::class)->create())
            ->get(route('day_data_points.edit', [
                $point->Serial,
                $point->TimeStamp->format('U'),
            ]))
            ->assertOk()
            ->assertViewIs('day_data_points.edit')
            ->assertViewHas([
                'dayDataPoint' => $point,
            ]);
    }

    /** @test */
    public function update_saves_and_redirects()
    {
        $points = factory(DayDataPoint::class, 2)->create();
        $data = factory(DayDataPoint::class)->make()->toArray();

        $this->actingAs(factory(User::class)->create())
            ->patch(route('day_data_points.edit', [
                $points->first()->Serial,
                $points->first()->TimeStamp->format('U')
            ]), $data)
            ->assertRedirect(route('graphs.day', $points->first()->TimeStamp->toDateString()))
            ->assertViewIs('graphs.day');

        $this->assertTrue(DayDataPoint::where($data)->exists());
        $this->assertTrue(DayDataPoint::where($points->first()->toArray())->doesntExist());
        $this->assertTrue(DayDataPoint::where($points->last()->toArray())->exists());
    }
}
