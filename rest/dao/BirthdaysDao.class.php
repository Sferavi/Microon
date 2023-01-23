<?php

require_once 'BaseDao.class.php';

class BirthdaysDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('birthdays');
    }
    public function get_birthdays_by_id($id)
    {
        $query = "SELECT * FROM birthdays WHERE id=:id";
        return @($this->execute_query($query, ['id' => $id]))[0];
    }
    public function get_my_birthdays($user_id)
    {
        $query = "SELECT * FROM birthdays WHERE user_id=:user_id";
        return @($this->execute_query($query, ['user_id' => $user_id]));
    }
    public function update_birthday($birthday, $birthday_id)
    {
        $entity[':id'] = $birthday_id;
        $query         = 'UPDATE birthdays SET ';
        foreach ($birthday as $key => $value) {
            $query .= $key . '=:' . $key . ', ';
            $entity[':' . $key] = $value;
        }
        $query = rtrim($query, ', ') . ' WHERE id=:id';
        return $this->update($entity, $query);
    }
}