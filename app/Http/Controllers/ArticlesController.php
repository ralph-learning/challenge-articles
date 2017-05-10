<?php

namespace App\Http\Controllers;

use App\Article;

class ArticlesController extends Controller
{

    public function index(Article $article)
    {
        return $article->all();
    }

    public function show($articleId)
    {

        $result = Article::find($articleId);

        if (!$result) {
            return response()->json(["code" => 404, "message" => "Article not found"], 404);
        }

        return $result;
    }

    public function store($data) {
        return $data;
    }
}

