<?php

namespace Tests\Feature;

use App\Models\Post;
use Tests\Traits\CallRoute;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthorsTest extends TestCase
{

    use RefreshDatabase, CallRoute;
    
    public function setUp(): void
    {

        parent::setUp();

        $this->withoutExceptionHandling([
            'Illuminate\Validation\ValidationException',
        ]);

        $user_a = 'USER_A';
        $user_b = 'USER_B';
        $user_c = 'USER_C';
        $user_d = 'USER_D';

        // popular a minha base...
        Post::insert([
            /* users user a */
            [
                'title' => Str::random(10),
                'author' => $user_a,
                'created_at' => now()->subDays(rand(1, 7)),
                'count_up_votes' => 6000,
                'count_comments' => 600,
                'original_id' => Str::random(32),
            ],
            [
                'title' => Str::random(10),
                'author' => $user_a,
                'created_at' => now()->subDays(rand(1, 7)),
                'count_up_votes' => 2000,
                'count_comments' => 200,
                'original_id' => Str::random(32),
            ],
            [
                'title' => Str::random(10),
                'author' => $user_a,
                'created_at' => now()->subDays(rand(1, 7)),
                'count_up_votes' => 1500,
                'count_comments' => 150,
                'original_id' => Str::random(32),
            ],
            [
                'title' => Str::random(10),
                'author' => $user_a,
                'created_at' => now()->subDays(rand(1, 7)),
                'count_up_votes' => 980,
                'count_comments' => 100,
                'original_id' => Str::random(32),
            ],
            [
                'title' => Str::random(10),
                'author' => $user_a,
                'created_at' => now()->subDays(rand(1, 7)),
                'count_up_votes' => 420,
                'count_comments' => 40,
                'original_id' => Str::random(32),
            ],
            /* users user b */
            [
                'title' => Str::random(10),
                'author' => $user_b,
                'created_at' => now()->subDays(rand(1, 7)),
                'count_up_votes' => 690,
                'count_comments' => 85,
                'original_id' => Str::random(32),
            ],
            [
                'title' => Str::random(10),
                'author' => $user_b,
                'created_at' => now()->subDays(rand(1, 7)),
                'count_up_votes' => 130,
                'count_comments' => 5,
                'original_id' => Str::random(32),
            ],
            /* users user c */
            [
                'title' => Str::random(10),
                'author' => $user_c,
                'created_at' => now()->subDays(rand(1, 7)),
                'count_up_votes' => 2,
                'count_comments' => 2,
                'original_id' => Str::random(32),
            ],
            /* users user d */
            [
                'title' => Str::random(10),
                'author' => $user_d,
                'created_at' => now()->subYears(rand(4, 7)),
                'count_up_votes' => 2,
                'count_comments' => 2,
                'original_id' => Str::random(32),
            ],
        ]);

    }

    /** @test */
    public function get_authors_filter()
    {

        $json = $this->call_route('api.v1.authors');

        $this->assertArrayHasKey('sucesso', $json);
        $this->assertTrue($json['sucesso']);

        $this->assertArrayHasKey('data', $json);
        $this->assertIsArray($json['data']);

        $this->assertCount(3, $json['data']);

    }

    /** @test */
    public function get_authors_sort_by_comments()
    {

        $json = $this->call_route('api.v1.authors');

        $users = $json['data'];

        for ($i = 0; $i < 2; $i++) {
            // verificando se esta ordenado
            $user = $users[$i];
            $next_user = $users[$i + 1];

            $this->assertGreaterThanOrEqual($next_user['count_comments'], $user['count_comments']);
        }
    }

    /** @test */
    public function get_authors_sort_by_upvotes()
    {

        $json = $this->call_route('api.v1.authors', 'count_up_votes');

        $users = $json['data'];

        for ($i = 0; $i < 2; $i++) {
            // verificando se esta ordenado
            $user = $users[$i];
            $next_user = $users[$i + 1];

            $this->assertGreaterThanOrEqual($next_user['count_up_votes'], $user['count_up_votes']);
        }
    }
}
