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

    /**
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Article $article)
    {
        $result = $article->all();

        return $this->respond([
            "data" => $this->articleTransformer->transformCollection($result->toArray())
        ]);
    }

    /**
     * @param $id
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id, Article $article)
    {
        $result = $article->find($id);
        if (!$result) return $this->respondNotFound('Article not found');

        return $this->respond([
            "data" => $this->articleTransformer->transform($result)
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules);
        if($validator->fails()) return $this->respondInvalidFields($validator);

        $input = $request->only(['title', 'content', 'status']);
        $article = new Article($input);
        if($article->save()) {
            return $this->respondCreated([
                "data" => $article,
                "message" => "Article create successful"
            ]);
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request, Article $article)
    {
        $result = $article->find($id);

        if(!$result) return $this->respondNotFound('Article does not exist');

        $input = $request->only(['title', 'content', 'status']);
        $article->fill($input);


        $validator = Validator::make($request->all(), $this->rules);
        if($validator->fails()) return $this->respondInvalidFields($validator);

        if($result->save() == false) {
           $this->respondWithErrors($validator);
        }

        return $this->respond([
            "message" => "Article updated"
        ]);
    }

    /**
     * @param $id
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, Article $article) {
        $article = $article->find($id);
        if(!$article) return $this->respondNotFound('Article does not exist');

        if($article->delete()) {
            return $this->respond([
                "message" => "Article removed with successful."
            ]);
        }
    }
}

