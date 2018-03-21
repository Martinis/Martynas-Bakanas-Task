<?php

namespace Tests\Feature;

ini_set('memory_limit', '-1');

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryLoadTest extends TestCase
{
    /**
     * Testing speed of tree generation using iterative function
     *
     * @return void
     */
    public function testIterativeGet()
    {
        $response = $this->json('GET', '/api/get/categories', ['type' => 'option2']);
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test category insertion into 32180 category
     *
     * @return void
     */
    public function testPackageGet()
    {
        $response = $this->json('GET', '/api/get/categories', ['type' => 'option1']);
        $this->assertEquals(200, $response->status());
    }
}
