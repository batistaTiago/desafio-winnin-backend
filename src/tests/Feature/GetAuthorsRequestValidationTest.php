<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetAuthorsRequestValidationTest extends TestCase
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
    public function get_all_authors_dates_are_required()
    {

        $this->followingRedirects();

        $sort_key = 'count_up_votes';

        $endpoint = route('api.v1.authors') . '?' . http_build_query(compact('sort_key'));

        $response = $this->get($endpoint, [
            'accept' => 'application/json',
        ]);

        $response->assertStatus(422);

        /* @TODO */
        // $response->assertSessionHasErrors('start_date');
        // $response->assertSessionHasErrors('end_date');

    }

    /** @test */
    public function get_all_authors_sort_key_is_required()
    {

        $this->followingRedirects();

        $start_date = now()->subDays(30)->toDateString();
        $end_date = now()->toDateString();

        $endpoint = route('api.v1.authors') . '?' . http_build_query(compact('start_date', 'end_date'));


        $response = $this->get($endpoint, [
            'accept' => 'application/json',
        ]);

        $response->assertStatus(422);

        /* @TODO */
        // $response->assertSessionHasErrors('start_date');
        // $response->assertSessionHasErrors('end_date');

    }

    /** @test */
    public function get_all_authors_filter_parameter_validation()
    {

        $this->followingRedirects();

        $start_date = 'abc';
        $end_date = 'def';

        $endpoint = route('api.v1.authors') . '?' . http_build_query(compact('start_date', 'end_date'));

        $response = $this->get($endpoint, [
            'accept' => 'application/json',
        ]);

        $response->assertStatus(422);

        /* @TODO */
        // $response->assertSessionHasErrors('start_date');
        // $response->assertSessionHasErrors('end_date');

    }

    /** @test */
    public function get_all_authors_sorting_parameter_validation()
    {

        $sort_key = 'asiothasio';

        $endpoint = route('api.v1.authors') . '?' . http_build_query(compact('sort_key'));

        $response = $this->get($endpoint, [
            'accept' => 'application/json',
        ]);

        $response->assertStatus(422);

    }
}
