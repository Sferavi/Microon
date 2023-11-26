<?php

require_once 'BaseDao.class.php';

class ExpenseDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('expense');
    }

    //EXPENSE
    public function get_expense_by_id($id)
    {
        $query = "SELECT * FROM expense WHERE id=:id";
        return @($this->execute_query($query, ['id' => $id]))[0];
    }

    public function get_my_expense($user_id)
    {
        $query = "SELECT * FROM expense WHERE user_id=:user_id";
        return @($this->execute_query($query, ['user_id' => $user_id]));
    }

}