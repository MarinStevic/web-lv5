<?php

namespace db;
require_once __DIR__ . "./../env.php";

use db\DbConfig as Config;


class DbHandler
{
    public $connection;

    public function connect()
    {
        $this->connection = new \mysqli(
            Config::HOST,
            Config::USER,
            Config::PASS,
            Config::DB
        );

        if ($this->connection->connect_errno) {
            echo "Connection failed {$this->connection->connect_errno}";
        }
    }

    public function disconnect()
    {
        $this->connection->close();
    }

    public function insert($queryInput)
    {
        $this->connect();

        $sql = $this->connection->query($queryInput);

        if (!$sql) {
            echo "Query fail";
        }

        $this->disconnect();
    }

    public function select($queryInput)
    {
        $this->connect();

        $sql = $this->connection->query($queryInput);

        if (!$sql) {
            echo "Query fail";
        }

        $this->disconnect();

        return $sql;
    }

    public function delete($queryInput)
    {
        $this->connect();

        $sql = $this->connection->query("DELETE FROM fighters WHERE id = '$queryInput'");

        if (!$sql) {
            echo "Query fail";
        }

        $this->disconnect();
    }

    public function update($queryInput) {
        
        $this->connect();

        $sql = $this->connection->query($queryInput);

        if(!$sql) {
            echo "Query fail";
        }
        $this->disconnect();
    }
}