<?php

$error = null;

function createUser($username, $password)
{
    $users = getUsers();

    $users[] = [
        'username' => $username,
        'password' => password_hash($password, PASSWORD_DEFAULT),
    ];

    file_put_contents('./data/users.json', json_encode($users));
}

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

if (isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = getUserByUsername($username);

    if ($user === false) {
        createUser($username, $password);
        header('Location: index.php?page=login');
        exit;
    } else {
        $error = 'Nom d\'utilisateur déjà utilisé';
    }
}

require './views/register.phtml';