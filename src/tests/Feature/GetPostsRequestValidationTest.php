<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetPostsRequestValidationTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {

        parent::setUp();

        $this->withoutExceptionHandling([
            'Illuminate\Validation\ValidationException',
        ]);
    }

    /** @test */
    public function get_all_posts_filter_parameter_validation()
    {

        $this->followingRedirects();

        $start_date = 'abc';
        $end_date = 'def';

        $endpoint = route('api.v1.posts') . '?' . http_build_query(compact('start_date', 'end_date'));

        $response = $this->get($endpoint, [
            'accept' => 'application/json',
        ]);

        $response->assertStatus(422);

        /* @TODO */
        // $response->assertSessionHasErrors('start_date');
        // $response->assertSessionHasErrors('end_date');

    }

    /** @test */
    public function get_all_posts_sorting_parameter_validation()
    {

        $sort_key = 'asiothasio';

        $endpoint = route('api.v1.posts') . '?' . http_build_query(compact('sort_key'));

        $response = $this->get($endpoint, [
            'accept' => 'application/json',
        ]);

        $response->assertStatus(422);

    }
}
