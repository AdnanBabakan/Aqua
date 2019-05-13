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

    protected function add_query($q, array $p = [])
    {
        $this->queries[] = [
            "query" => $q,
            "params" => $p
        ];
    }

    public function table(string $t)
    {
        foreach($this->queries as $query) {
            $result = $this->db_conn->prepare(str_replace('{{table}}', $t, $query["query"]));
            $result->execute($query["params"]);
        }

        if($this->fetch == 1) {
            $result = $result->fetchAll(2);
        } elseif($this->fetch == 2) {
            $result = $result->fetch(2);
            
        }

        $this->queries = [];
        $this->fetch = false;

        return $result;
    }

    public function insert(array $p)
    {
        $sql = "INSERT INTO {{table}} (" . implode(', ', array_keys($p)) . ") VALUES (" . implode(', ', array_map(function($d) {
            return ":$d";
        }, array_keys($p))) . ")";
        
        $this->add_query($sql, $p);

        return $this;
    }

    protected $fetch = 0;

    public function select(...$s)
    {
        $this->fetch = 1;
        
        if(isset($s[0]) and is_array($s[0])) {
            $s = $s[0];
        }
        $s or $s = ['*'];

        $this->add_query('SELECT ' . implode(', ', $s) . ' FROM {{table}}');
        
        return $this;
    }

    public function first(...$s)
    {
        $this->select(...$s);
        $this->fetch = 2;

        return $this;
    }
}