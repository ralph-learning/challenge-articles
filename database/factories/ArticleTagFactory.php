<?php

$factory->define(App\ArticleTag::class, function (Faker\Generator $faker) {
    $articles = App\Article::select('id')->where('id' ,'>' ,0)->get()->toArray();
    $articlesId = array_map(function($id) {
        return $id['id'];
    }, $articles);


    $tags = App\Tag::select('id')->where('id' ,'>' ,0)->get()->toarray();
    $tagsId = array_map(function($id) {
        return $id['id'];
    }, $tags);

    return [
        'article_id' => $faker->randomElement($articlesId),
        'tag_id' => $faker->randomElement($tagsId)
    ];
});
