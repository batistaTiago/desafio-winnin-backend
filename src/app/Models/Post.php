<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;

    public static function getAllWithFilters($filters, $sort_key)
    {
        return Post::whereBetween('created_at', $filters)
            ->orderBy($sort_key, 'desc')
            ->get();
    }

    public static function getGroupedAuthorsWithFilters($filters, $sort_key)
    {
        return Post::select([
            'posts.author',
            DB::raw('SUM(posts.count_comments) as count_comments'),
            DB::raw('SUM(posts.count_up_votes) as count_up_votes'),
        ])
            ->whereBetween('created_at', $filters)
            ->groupBy('posts.author')
            ->orderBy($sort_key, 'desc')
            ->get();
    }
}
