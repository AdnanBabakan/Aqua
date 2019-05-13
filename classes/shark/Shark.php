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

    public function query($q, array $p = [])
    {
        $this->prepare($q)->execute($p);

        return $this;
    }

    public function insert(string $t, array $p)
    {
        $sql = "INSERT INTO $t (" . implode(', ', array_keys($p)) . ") VALUES (" . implode(', ', array_map(function($d) {
            return ":$d";
        }, array_keys($p))) . ")";
        
        $this->query($sql, $p);

        return $this;
    }
}