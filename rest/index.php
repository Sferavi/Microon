<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS, PATCH');

require 'auth.php';
require_once('../vendor/autoload.php');
require_once('config.php');
require_once('dao/UsersDao.class.php');
require_once('dao/NotesDao.class.php');
require_once('dao/BirthdaysDao.class.php');
require_once('dao/ShoppingListDao.class.php');
require_once('dao/IncomeDao.class.php');
require_once('dao/ExpenseDao.class.php');

Flight::register('user_dao', 'UsersDao');
Flight::register('notes_dao', 'NotesDao');
Flight::register('birthdays_dao', 'BirthdaysDao');
Flight::register('shopping_list_dao', 'ShoppingListDao');
Flight::register('income_dao', 'IncomeDao');
Flight::register('expense_dao', 'ExpenseDao');

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

Flight::route('POST /birthdays', function () {
    $birthdays            = Flight::request()->data->getData();
    Flight::birthdays_dao()->add($birthdays);
});

Flight::route('POST /shopping_item', function () {
    $shopping_item            = Flight::request()->data->getData();
    Flight::shopping_list_dao()->add($shopping_item);
});

Flight::route('POST /new_income', function () {
    $new_income           = Flight::request()->data->getData();
    Flight::income_dao()->add($new_income);
});

Flight::route('POST /new_expense', function () {
    $new_expense           = Flight::request()->data->getData();
    Flight::expense_dao()->add($new_expense);
});

Flight::route('POST /birthday/@id', function ($id) {
    $birthdays = Flight::request()->data->getData();
    Flight::birthdays_dao()->update_birthday($birthdays, $id);
});

Flight::route('POST /note/@id', function ($id) {
    $notes = Flight::request()->data->getData();
    Flight::notes_dao()->update_note($notes, $id);
});

Flight::route('GET /my_notes', function () {
    $my_notes = Flight::notes_dao()->get_all();
    Flight::json($my_notes);
});

Flight::route('GET /my_birthdays', function () {
    $my_birthdays = Flight::birthdays_dao()->get_all();
    Flight::json($my_birthdays);
});

Flight::route('GET /shopping_list', function()
{
  $shopping_list = Flight::shopping_list_dao()->get_all();
  Flight::json($shopping_list);
});

Flight::route('GET /income_list', function()
{
  $income_list = Flight::income_dao()->get_all();
  Flight::json($income_list);
});

Flight::route('GET /expense_list', function()
{
  $expense_list = Flight::expense_dao()->get_all();
  Flight::json($expense_list);
});

Flight::route('GET /high_priority', function()
{
  $shopping_list = Flight::shopping_list_dao()->get_high_priority();
  Flight::json($shopping_list);
});

Flight::route('GET /birthday/@id', function ($id) {
    $birthday = Flight::birthdays_dao()->get_birthdays_by_id($id);
    Flight::json($birthday);
});

Flight::route('GET /note/@id', function ($id) {
    $note = Flight::notes_dao()->get_notes_by_id($id);
    Flight::json($note);
});

Flight::route('DELETE /birthday/@id', function ($id) {
    Flight::birthdays_dao()->delete_birthday($id);
});

Flight::route('DELETE /note/@id', function ($id) {
    Flight::notes_dao()->delete_note($id);
});

Flight::start();