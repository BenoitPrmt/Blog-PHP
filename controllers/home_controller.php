<?php

function getAllArticles(): array {
    $result = [];
    $handle = fopen('./data/articles.csv', 'r');

    if (!$handle) {
        return [];
    }

    while (false !== ($data = fgetcsv($handle, null, ';'))) {
        $data = explode(',', $data);
        $result[] = $data;
    }
    if (count($result) === 0) {
        return [0];
    }
    return $result;
}

$last_article_id = getLastArticle()[0];

echo $last_article_id;

require './views/home.phtml';