<?php

require_once 'BaseDao.class.php';

class IncomeDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('income');
    }

    //INCOME
    public function get_income_by_id($id)
    {
        $query = "SELECT * FROM income WHERE id=:id";
        return @($this->execute_query($query, ['id' => $id]))[0];
    }

    public function get_my_income($user_id)
    {
        $query = "SELECT * FROM income WHERE user_id=:user_id";
        return @($this->execute_query($query, ['user_id' => $user_id]));
    }

}