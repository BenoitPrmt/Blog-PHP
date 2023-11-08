<?php

function getAllArticles(): array
{
    $result = [];
    $handle = fopen('./data/articles.csv', 'r');

    if (!$handle) {
        return [];
    }

    while (false !== ($data = fgetcsv($handle, null, ';'))) {
        $data = explode(',', $data[0]);
        $result[] = $data;
    }
    if (count($result) === 0) {
        return [0];
    }
    return $result;
}

function getLastArticleId(): int
{
    $result = [];
    $handle = fopen('./data/articles.csv', 'r');

    if (!$handle) {
        return -1;
    }

    while (false !== ($data = fgetcsv($handle, null, ';'))) {
        $data = explode(',', $data[0]);
        $result[] = $data;
    }

    if (count($result) === 0) {
        return 0;
    }

    $last_article = end($result);

    return intval($last_article[0]);
}

function getPostsToShow(int $last_id, array $articles, int $max_posts = 15): array
{

    $posts_to_show = [];
    $min_id = $last_id - $max_posts+1;
    $total_articles = count($articles);

    if ($min_id < 1) {
        $min_id = 1;
    }

    for ($i = $last_id; $i >= $min_id; $i--) {
        if ($i > $total_articles) {
            continue;
        }
        $posts_to_show[] = $articles[$i - 1];
    }

    return $posts_to_show;
}

$last_id = getLastArticleId();

$articles = getAllArticles();

$posts = getPostsToShow($last_id, $articles);

require './views/home.phtml';