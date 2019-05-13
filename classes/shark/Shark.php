<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * This file is the main class that handles routes acrros the appliaction
 */

namespace Aqua;

class Shark
{
    protected $db_conn;
    protected $queries = [];

    public function __construct()
    {
        $db = Core::config()->database;

        try {
            $this->db_conn = new \PDO("mysql:host={$db->address}:{$db->port};dbname={$db->name}", $db->username, $db->password);
            $this->db_conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch(\PDOException $e) {
            die('Database connection error!');
        }
    }

    protected function prepare($q)
    {
        return $this->db_conn->prepare($q);
    }

    public function table(string $t)
    {
        
        $this->execute_queries($t);

        return $this;
    }

    protected function add_query($q, array $p = [])
    {
        $this->queries[] = [
            "query" => $q,
            "params" => $p
        ];
    }

    protected function execute_queries(string $t)
    {
        foreach($this->queries as $query) {
            $this->db_conn->prepare(str_replace('{{table}}', $t, $query["query"]))->execute($query["params"]);
        }

        return $this;
    }

    public function insert(array $p)
    {
        $sql = "INSERT INTO {{table}} (" . implode(', ', array_keys($p)) . ") VALUES (" . implode(', ', array_map(function($d) {
            return ":$d";
        }, array_keys($p))) . ")";
        
        $this->add_query($sql, $p);

        return $this;
    }

    public function select()
    {

    }
}