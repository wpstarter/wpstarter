<?php

namespace Tests\Feature;

use WpStarter\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/welcome');

        $response->assertStatus(200);
    }
}
