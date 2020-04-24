<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GraphControllerTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function home_redeirects_to_day() {
        $this->get('/')
            ->assertRedirect(route('graphs.day'));
    }

    /** @test */
    public function day_returns_expected_response()
    {
        $this->get(route('graphs.day'))
            ->assertOk()
            ->assertViewIs('graphs.day')
            ->assertViewHas([
                'date' => today()->endOfDay(),
            ]);
    }

    /** @test */
    public function month_returns_expected_response()
    {
        $this->get(route('graphs.month'))
            ->assertOk()
            ->assertViewIs('graphs.month')
            ->assertViewHas([
                'date' => today()->endOfMonth(),
            ]);
    }

    /** @test */
    public function year_returns_expected_response()
    {
        $this->get(route('graphs.year'))
            ->assertOk()
            ->assertViewIs('graphs.year')
            ->assertViewHas([
                'date' => today()->endOfYear(),
            ]);
    }
}
