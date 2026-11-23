<?php

class Database
{
    private $host = "sql110.infinityfree.com";
    private $dbname = "if0_43508509_libreria";
    private $user = "if0_43508509";
    private $password = "WT4IbA4JX4Bwy3l";

    private $db;

    public function getConnection()
    {
        $this->db = null;

        try {
            $dsn = "mysql:host=" . $this->host .
                   ";dbname=" . $this->dbname .
                   ";charset=utf8mb4";

            $this->db = new PDO(
                $dsn,
                $this->user,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );

        } catch (PDOException $e) {
            error_log($e->getMessage());

            throw new RuntimeException(
                "No fue posible conectar con la base de datos."
            );
        }

        return $this->db;
    }
}