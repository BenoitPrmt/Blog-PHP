<?php

function getArticle(int $id): array {

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
        return [];
    }

    $article = $result[$id - 1];

    return $article;

}

if (!isset($_GET['id'])) {
    header('Location: ?page=home');
    exit;
}

$post = getArticle($_GET['id']);

if (count($post) === 0) {
    header('Location: ?page=home');
    exit;
}

require './views/article.phtml';