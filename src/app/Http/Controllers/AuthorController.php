<?php

namespace App\Http\Controllers;

use App\Http\Requests\API\GetAuthorsRequest;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    public function index(GetAuthorsRequest $request)
    {
        $sucesso = true;

        $filters = $request->only('start_date', 'end_date');
        $sort_key = $request->sort_key;

        $data = Post::getGroupedAuthorsWithFilters($filters, $sort_key);

        return response()->json(compact('sucesso', 'data'));
    }
}
