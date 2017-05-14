<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Transforms\ArticleTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ArticlesController extends ApiController
{
    private $rules = [
        "title" => "required|max:255",
        "content" => "required"
    ];

    protected $articleTransformer;

    function __construct(ArticleTransformer $articleTransformer)
    {
        $this->articleTransformer = $articleTransformer;
    }

    public function index(Article $article)
    {
        $result = $article->all();

        return $this->respond([
            "data" => $this->articleTransformer->transformCollection($result->toArray())
        ]);
    }

    public function show($id, Article $article)
    {
        $result = $article->find($id);
        if (!$result) return $this->respondNotFound('Article not found');

        return $this->respond([
            "data" => $this->articleTransformer->transform($result)
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules);
        if($validator->fails()) return $this->respondInvalidFields($validator);


        $input = $request->only(['title', 'content', 'status']);
        $article = new Article($input);
        if($article->save()) {
            return $this->respond([
                "data" => $article,
                "message" => "Article create successful"
            ]);
        }
    }

    public function update($id, Request $request, Article $article)
    {
        $article = $article->find($id);

        if(!$article) return $this->respondNotFound('Article does not exist');

        $article->title = $request->get('title');
        $article->content = $request->get('content');
        $article->status = $request->get('status');

        $validator = Validator::make($request->all(), $this->rules);
        if($validator->fails()) return $this->respondInvalidFields($validator);

        if($article->save()) {
            return $this->respond([
                "message" => "Article updated"
            ]);
        }
    }
}

