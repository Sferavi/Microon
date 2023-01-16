<?php

require_once 'BaseDao.class.php';

class NotesDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('notes');
    }
    public function get_notes_by_id($id)
    {
        $query = "SELECT * FROM notes WHERE id=:id";
        return @($this->execute_query($query, ['id' => $id]))[0];
    }
}