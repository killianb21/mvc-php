<?php
class DatabaseConnection
{
    public $database = null;
    public function getConnection()
    {
        if ($this->database === null) {
            $this->database = new PDO('mysql:host=localhost;dbname=blog;
            charset=utf8', 'root', 'root');
        }
        return $this->database;
    }
}
