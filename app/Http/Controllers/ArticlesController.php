<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{

    public function index(Article $article)
    {
        return $article->all();
    }

    public function show(Article $article, $id)
    {
        $result = $article->find($id);

        if (!$result) {
            return response()->json(["code" => 404, "message" => "Article not found"], 404);
        }

        return $result;
    }
}

