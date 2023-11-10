<?php

$error = null;

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
        $error = 'Nom d\'utilisateur ou mot de passe incorrect';
    } else {
        if (password_verify($password, $user['password'])) {

            setcookie('user', $user['username'].'.SEP.'.$user['password'].'.SEP.'.$user['uuid'], time() + 60*60*24);

            header('Location: index.php');
            exit;
        } else {
            $error = 'Nom d\'utilisateur ou mot de passe incorrect';
        }
    }
}

require './views/login.phtml';