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

    public function show($articleId)
    {

        $result = Article::find($articleId);

        if (!$result) {
            return response()->json(["code" => 404, "message" => "Article not found"], 404);
        }

        return $result;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'content' => 'required'
        ]);

        $input = $request->only(['title', 'content', 'status']);

        $article = new Article($input);

        $article->save();

        return response()->json([
            "data" => $article,
            "code" => 200,
            "message" => "Aaticle create successful"
        ], 200);
    }
}

