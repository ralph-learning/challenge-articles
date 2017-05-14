<?php

namespace App\Http\Transforms;

class ArticleTransformer extends Transformer {

    public function transform($article)
    {
        return [
            'id' => $article['id'],
            'title' => $article['title'],
            'body' => $article['content'],
            'status' => $article['status']
        ];
    }
}