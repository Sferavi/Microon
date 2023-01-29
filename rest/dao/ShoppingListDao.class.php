<?php

require_once 'BaseDao.class.php';

class ShoppingListDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('shopping_list');
    }

    public function get_shopping_list_by_id($id)
    {
        $query = "SELECT * FROM shopping_list WHERE id=:id";
        return @($this->execute_query($query, ['id' => $id]))[0];
    }

    public function get_my_shopping_list($user_id)
    {
        $query = "SELECT * FROM shopping_list WHERE user_id=:user_id";
        return @($this->execute_query($query, ['user_id' => $user_id]));
    }

}