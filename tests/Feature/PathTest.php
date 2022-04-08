<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PathTest extends TestCase
{
    /**
     * Test for home view
     *
     * @return void
     */
    public function testWelcomePage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
