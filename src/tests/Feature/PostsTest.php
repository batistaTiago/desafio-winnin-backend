<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class PostsTest extends TestCase
{

    use RefreshDatabase;

    /**
     * 1o endpoint posts
     * 2o users
     */

    public function setUp(): void
    {

        parent::setUp();

        $this->withoutExceptionHandling([
            'Illuminate\Validation\ValidationException',
        ]);

        // popular a minha base...
        Post::insert([
            /* posts antigos */
            [
                'title' => Str::random(10),
                'author' => Str::random(10),
                'created_at' => now()->subMonth(rand(2, 30)),
                'count_up_votes' => rand(0, 10000),
                'count_comments' => rand(0, 500),
            ],
            [
                'title' => Str::random(10),
                'author' => Str::random(10),
                'created_at' => now()->subMonth(rand(2, 30)),
                'count_up_votes' => rand(0, 10000),
                'count_comments' => rand(0, 500),
            ],
            [
                'title' => Str::random(10),
                'author' => Str::random(10),
                'created_at' => now()->subMonth(rand(2, 30)),
                'count_up_votes' => rand(0, 10000),
                'count_comments' => rand(0, 500),
            ],
            [
                'title' => Str::random(10),
                'author' => Str::random(10),
                'created_at' => now()->subMonth(rand(2, 30)),
                'count_up_votes' => rand(0, 10000),
                'count_comments' => rand(0, 500),
            ],
            /* posts da semana */
            [
                'title' => Str::random(10),
                'author' => Str::random(10),
                'created_at' => now()->subDays(rand(1, 7)),
                'count_up_votes' => rand(0, 10000),
                'count_comments' => rand(0, 500),
            ],
            [
                'title' => Str::random(10),
                'author' => Str::random(10),
                'created_at' => now()->subDays(rand(1, 7)),
                'count_up_votes' => rand(0, 10000),
                'count_comments' => rand(0, 500),
            ],
            [
                'title' => Str::random(10),
                'author' => Str::random(10),
                'created_at' => now()->subDays(rand(1, 7)),
                'count_up_votes' => rand(0, 10000),
                'count_comments' => rand(0, 500),
            ],
            [
                'title' => Str::random(10),
                'author' => Str::random(10),
                'created_at' => now()->subDays(rand(1, 7)),
                'count_up_votes' => rand(0, 10000),
                'count_comments' => rand(0, 500),
            ],
        ]);

    }

    /** @test */
    public function get_all_posts()
    {

        $endpoint = route('api.v1.posts');

        $response = $this->get($endpoint, [
            'accept' => 'application/json',
        ]);

        $response->assertStatus(200);

        $json = $response->decodeResponseJson();

        $this->assertArrayHasKey('sucesso', $json);
        $this->assertTrue($json['sucesso']);

        $this->assertArrayHasKey('data', $json);

        $this->assertGreaterThan(0, count($json['data']));
        $this->assertEquals(Post::all()->count(), count($json['data'])); // garanto veio todos os posts
    }

    /** @test */
    public function get_all_posts_filters()
    {

        $start_date = now()->subDays(30)->toDateString();
        $end_date = now()->toDateString();

        $endpoint = route('api.v1.posts') . '?' . http_build_query(compact('start_date', 'end_date'));

        $response = $this->get($endpoint, [
            'accept' => 'application/json',
        ]);

        $response->assertStatus(200);

        $json = $response->decodeResponseJson();

        $this->assertArrayHasKey('sucesso', $json);
        $this->assertTrue($json['sucesso']);

        $this->assertArrayHasKey('data', $json);
        $this->assertIsArray($json['data']);

        $this->assertGreaterThan(0, count($json['data']));

        $posts = $json['data'];

        $this->assertEquals(4, count($posts));

    }

    /** @test */
    public function get_all_posts_sorting_by_upvotes()
    {
        $sort_key = 'count_up_votes';

        $endpoint = route('api.v1.posts') . '?' . http_build_query(compact('sort_key'));

        $response = $this->get($endpoint, [
            'accept' => 'application/json',
        ]);

        $response->assertStatus(200);

        $json = $response->decodeResponseJson();

        $this->assertArrayHasKey('sucesso', $json);
        $this->assertTrue($json['sucesso']);

        $this->assertArrayHasKey('data', $json);
        $this->assertIsArray($json['data']);

        $this->assertGreaterThan(0, count($json['data']));

        $posts = $json['data'];

        $this->assertEquals(8, count($posts));

        for ($i = 0; $i < 7; $i++) {
            $post = $posts[$i];
            $next_post = $posts[$i + 1];

            $this->assertGreaterThanOrEqual($next_post['count_up_votes'], $post['count_up_votes']);
        }

    }

    /** @test */
    public function get_all_posts_sorting_by_comments()
    {
        $sort_key = 'count_comments';

        $endpoint = route('api.v1.posts') . '?' . http_build_query(compact('sort_key'));

        $response = $this->get($endpoint, [
            'accept' => 'application/json',
        ]);

        $response->assertStatus(200);

        $json = $response->decodeResponseJson();

        $this->assertArrayHasKey('sucesso', $json);
        $this->assertTrue($json['sucesso']);

        $this->assertArrayHasKey('data', $json);
        $this->assertIsArray($json['data']);

        $this->assertGreaterThan(0, count($json['data']));

        $posts = $json['data'];

        $this->assertEquals(8, count($posts));

        for ($i = 0; $i < 7; $i++) {
            $post = $posts[$i];
            $next_post = $posts[$i + 1];

            $this->assertGreaterThanOrEqual($next_post['count_comments'], $post['count_comments']);
        }

    }
}
