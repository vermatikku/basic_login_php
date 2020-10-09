<?php

class CommonFunctions
{
    private $db_connection = null;
    private function databaseConnection()
    {
        if ($this->db_connection != null) {
            return true;
        } else {
            try {
                $this->db_connection = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
                return true;
            } catch (PDOException $e) {
                echo $e->getMessage();
                #$this->errors[] = MESSAGE_DATABASE_ERROR . $e->getMessage();
            }
        }
        return false;
    }
    public function loginFunction($user_id, $password)
    {
        if ($this->databaseConnection()) {
            $insert_query = $this->db_connection->prepare("SELECT user_id FROM login WHERE user_id=:user_id AND password = md5(:password)");
            $insert_query->bindValue(':user_id', trim($user_id), PDO::PARAM_STR);
            $insert_query->bindValue(':password', trim($password), PDO::PARAM_STR);
            $status = $insert_query->execute();
            if ($status) {
                return $insert_query->fetchObject();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
