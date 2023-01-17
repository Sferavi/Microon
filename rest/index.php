<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS, PATCH');

require 'auth.php';
require_once('../vendor/autoload.php');
require_once('config.php');
require_once('dao/UsersDao.class.php');
require_once('dao/NotesDao.class.php');

Flight::register('user_dao', 'UsersDao');
Flight::register('notes_dao', 'NotesDao');

Flight::route('POST /users', function () {
    $user = Flight::request()->data->getData();
    Flight::user_dao()->add($user);
});

Flight::route('POST /login', function () {
    $user    = Flight::request()->data->getData();
    $db_user = Flight::user_dao()->get_user_by_email($user['email']);

    if ($db_user) {
        if ($db_user['password'] == $user['password']) {
            $token_data = [
        'email' => $db_user['email']
      ];
            $jwt = Auth::encode_jwt($token_data);
            Flight::json(['user_token' => $jwt]);
        } else {
            Flight::halt(404, 'Incorrect password');
        }
    } else {
        Flight::halt(404, 'User not found');
    }
});

Flight::route('POST /notes', function () {
    $notes            = Flight::request()->data->getData();
    Flight::notes_dao()->add($notes);
});

Flight::route('GET /my_notes', function () {
    $my_notes = Flight::notes_dao()->get_all();
    Flight::json($my_notes);
});

Flight::start();