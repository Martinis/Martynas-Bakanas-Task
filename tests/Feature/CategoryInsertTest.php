<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryInsertTest extends TestCase
{
    /**
     * Test root category insertion
     *
     * @return void
     */
    public function testRootCategory()
    {
        $response = $this->json('GET', '/api/add/category', ['name' => 'Root Test']);
        $response
            ->assertStatus(200)
            ->assertJson([
                0 => 'green',
                1 => 'smile-o',
                2 => 'You successfully created your category',
            ]);
    }

    /**
     * Test category insertion into 1 category
     *
     * @return void
     */
    public function testRootSubCategory()
    {
        $response = $this->json('GET', '/api/add/category', ['name' => 'Sub Root Test', 'parent' => 1]);
        $response
            ->assertStatus(200)
            ->assertJson([
                0 => 'green',
                1 => 'smile-o',
                2 => 'You successfully created your category',
            ]);
    }
}
