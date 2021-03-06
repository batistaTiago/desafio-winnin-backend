<?php

namespace App\Http\Controllers;

use App\Http\Requests\API\GetAllPostsRequest;
use App\Models\Post;

class PostController extends Controller
{
    public function index(GetAllPostsRequest $request)
    {
        $sucesso = true;

        $filters = $request->only('start_date', 'end_date');
        $sort_key = $request->sort_key;

        $data = Post::getAllWithFilters($filters, $sort_key);

        return response()->json(compact('sucesso', 'data'));
    }
}
