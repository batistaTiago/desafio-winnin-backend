<?php

namespace App\Console\Commands;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class FetchRedditHotData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:reddit';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            echo 'Iniciando integracao';
            echo PHP_EOL;
            DB::beginTransaction();

            $response = Http::get('https://api.reddit.com/r/artificial/hot');
            $raw_data = $response->json();

            $data = collect($raw_data['data']['children'])->map(function ($item) {
                return [
                    'original_id' => $item['data']['id'],
                    'author' => $item['data']['author'],
                    'title' => $item['data']['title'],
                    'created_at' => Carbon::parse($item['data']['created_utc'])->toDatetimeString(),
                    'count_comments' => $item['data']['ups'],
                    'count_up_votes' => $item['data']['num_comments'],
                ];
            });

            echo 'Request ok';
            echo PHP_EOL;

            $posts = Post::select('id', 'original_id')->get()->pluck('original_id');

            $data = $data->filter(function ($item) use ($posts) {
                return !$posts->contains($item['original_id']);
            });

            echo 'Filtro ok';
            echo PHP_EOL;

            Post::insert($data->toArray());

            DB::commit();

            echo 'Commit ok';
            echo PHP_EOL;
        } catch (\Throwable $e) {
            echo $e->getMessage();
            echo PHP_EOL;
            DB::rollBack();
        }
    }
}
