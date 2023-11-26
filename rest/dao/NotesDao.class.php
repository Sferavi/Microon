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
    public function get_my_notes($user_id)
    {
        $query = "SELECT * FROM notes WHERE user_id=:user_id";
        return @($this->execute_query($query, ['user_id' => $user_id]));
    }

    public function update_note($note, $note_id)
    {
        $entity[':id'] = $note_id;
        $query         = 'UPDATE notes SET ';
        foreach ($note as $key => $value) {
            $query .= $key . '=:' . $key . ', ';
            $entity[':' . $key] = $value;
        }
        $query = rtrim($query, ', ') . ' WHERE id=:id';
        return $this->update($entity, $query);
    }

    public function delete_note($id)
    {
        $query = "DELETE FROM notes WHERE id =:id";
        return $this->execute_query1($query, ['id' => $id]);
    }
}