<?php

function getUsers()
{
    $users = file_get_contents('./data/users.json');
    $users = json_decode($users, true);

    return $users;
}

function getUserByUsername($username)
{
    $users = getUsers();

    foreach ($users as $user) {
        if ($user['username'] === $username) {
            return $user;
        }
    }

    return false;
}

function getLastArticle(): array
{
    $result = [];
    $handle = fopen('./data/articles.csv', 'r');

    if (!$handle) {
        return [];
    }

    while (false !== ($data = fgetcsv($handle, null, ';'))) {
        $result[] = $data;
    }

    if (count($result) === 0) {
        return [0];
    }
    return explode(',', end($result)[0]);
}

function incrementId(array $last_article): int
{
    if (count($last_article) === 0) {
        return -1;
    }
    return intval($last_article[0]) + 1;
}

if (count($_POST) !== 0) {

    if ($_POST['title'] !== '' && $_POST['description'] !== '' && $_POST['author'] !== '') {

        if (strlen($_POST['title']) < 15 && strlen($_POST['description']) < 255) {
            $articles_database = fopen("./data/articles.csv", "a");

            $article_id = '"' . incrementId(getLastArticle()) . '"';
            $article_title = '"' . $_POST['title'] . '"';
            $article_description = '"' . trim(preg_replace('/\s+/', ' ', $_POST['description'])) . '"';
            $article_author = explode('.SEP.', $_COOKIE['user'])[0];
            $article_date = '"' . time() . '"';

            fputcsv($articles_database, [$article_id, $article_title, $article_description, $article_author, $article_date], ',', ' ');

            fclose($articles_database);

            header('Location: index.php');
            die;
        } else {
            echo 'Erreur, veuillez vérifier la longueur de vos informations'
;        }
    } else {
        echo 'Erreur, veuillez remplir toutes les informations demandées';
    }
} else {
    echo 'Remplissez les champs ci-dessous puis cliquez sur "Poster l\'article"';
}

require './views/create.phtml';