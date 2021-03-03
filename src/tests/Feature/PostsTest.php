<?php

namespace Tests\Feature;

use App\Models\Post;
use Tests\Traits\CallRoute;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class PostsTest extends TestCase
{

    use RefreshDatabase, CallRoute;

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
                'original_id' => Str::random(32),
            ],
            [
                'title' => Str::random(10),
                'author' => Str::random(10),
                'created_at' => now()->subMonth(rand(2, 30)),
                'count_up_votes' => rand(0, 10000),
                'count_comments' => rand(0, 500),
                'original_id' => Str::random(32),
            ],
            [
                'title' => Str::random(10),
                'author' => Str::random(10),
                'created_at' => now()->subMonth(rand(2, 30)),
                'count_up_votes' => rand(0, 10000),
                'count_comments' => rand(0, 500),
                'original_id' => Str::random(32),
            ],
            [
                'title' => Str::random(10),
                'author' => Str::random(10),
                'created_at' => now()->subMonth(rand(2, 30)),
                'count_up_votes' => rand(0, 10000),
                'count_comments' => rand(0, 500),
                'original_id' => Str::random(32),
            ],
            /* posts da semana */
            [
                'title' => Str::random(10),
                'author' => Str::random(10),
                'created_at' => now()->subDays(rand(1, 7)),
                'count_up_votes' => rand(0, 10000),
                'count_comments' => rand(0, 500),
                'original_id' => Str::random(32),
            ],
            [
                'title' => Str::random(10),
                'author' => Str::random(10),
                'created_at' => now()->subDays(rand(1, 7)),
                'count_up_votes' => rand(0, 10000),
                'count_comments' => rand(0, 500),
                'original_id' => Str::random(32),
            ],
            [
                'title' => Str::random(10),
                'author' => Str::random(10),
                'created_at' => now()->subDays(rand(1, 7)),
                'count_up_votes' => rand(0, 10000),
                'count_comments' => rand(0, 500),
                'original_id' => Str::random(32),
            ],
            [
                'title' => Str::random(10),
                'author' => Str::random(10),
                'created_at' => now()->subDays(rand(1, 7)),
                'count_up_votes' => rand(0, 10000),
                'count_comments' => rand(0, 500),
                'original_id' => Str::random(32),
            ],
        ]);
    }

    /** @test */
    public function get_all_posts_filters()
    {

        $json = $this->call_route('api.v1.posts');

        $this->assertArrayHasKey('sucesso', $json);
        $this->assertTrue($json['sucesso']);

        $this->assertArrayHasKey('data', $json);
        $this->assertIsArray($json['data']);

        $this->assertCount(4, $json['data']);
    }

    /** @test */
    public function get_all_posts_sorting_by_upvotes()
    {

        $json = $this->call_route('api.v1.posts', 'count_up_votes');
        $posts = $json['data'];

        for ($i = 0; $i < 3; $i++) {
            $post = $posts[$i];
            $next_post = $posts[$i + 1];

            $this->assertGreaterThanOrEqual($next_post['count_up_votes'], $post['count_up_votes']);
        }
    }

    /** @test */
    public function get_all_posts_sorting_by_comments()
    {
        $json = $this->call_route('api.v1.posts');
        $posts = $json['data'];

        for ($i = 0; $i < 3; $i++) {
            $post = $posts[$i];
            $next_post = $posts[$i + 1];

            $this->assertGreaterThanOrEqual($next_post['count_comments'], $post['count_comments']);
        }
    }
}
