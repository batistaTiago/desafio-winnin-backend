<?php

namespace App\Http\Controllers;

use App\Http\Requests\API\GetAllPostsRequest;
use App\Models\Post;

class PostController extends Controller
{
    public function index(GetAllPostsRequest $request)
    {

        $data = Post::query();

        if (isset($request->start_date)) {
            $data->where('created_at', '>', $request->start_date);
        }

        if (isset($request->end_date)) {
             $data->where('created_at', '<', $request->end_date);
        }

        if (isset($request->sort_key)) {
            $data->orderBy($request->sort_key, 'desc');
        }

        $data = $data->get();

        return response()->json([
            'sucesso' => true,
            'data' => $data,
        ]);
    }
}
