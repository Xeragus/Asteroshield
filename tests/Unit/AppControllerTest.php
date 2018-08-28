<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\AppController;

class AppControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        // $this->call('GET', 'posts');
        $controller = new AppController;
        $this->assertEquals(5, $controller->getNumber(5));
        // $this->assertTrue(true);
    }
}
