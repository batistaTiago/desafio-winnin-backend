<?php

namespace Tests\Traits;

trait CallRoute
{
    /* helper */
    private function call_route($route_name, $sort_key = 'count_comments', $start_date = null, $end_date = null)
    {
        $start_date = $start_date ?? now()->subDays(30)->toDateString();
        $end_date = $end_date ?? now()->toDateString();
        $sort_key = $sort_key ?? 'count_comments';

        $endpoint = route($route_name) . '?' . http_build_query(compact('start_date', 'end_date', 'sort_key'));

        $response = $this->get($endpoint, [
            'accept' => 'application/json',
        ]);

        $response->assertStatus(200);

        $json = $response->decodeResponseJson();

        return $json;
    }
}
