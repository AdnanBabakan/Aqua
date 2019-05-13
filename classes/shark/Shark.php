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
            
            $sql = str_replace('{{table}}', $t, $query["query"]);
            $sql = str_replace('{{where}}', 'WHERE' . preg_replace('/^(.*?)(AND|OR)/', '', implode('', $this->where["queries"])), $sql);
            
            $result = $this->db_conn->prepare($sql);
            $result->execute(array_merge($query["params"], $this->where['params']));
        }

        if($this->fetch == 1) {
            $result = $result->fetchAll(2);
        } elseif($this->fetch == 2) {
            $result = $result->fetch(2); 
        }

        $this->queries = [];
        $this->fetch = false;
        $this->where = [];

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

    public $where = [
        "queries" => [],
        "params" => []
    ];

    protected function where_do($o, $s)
    {
        $clause = [];
        $clause_string = [];

        if(!is_array($s[0])) {
            
            $clause = [$s];

        } else {
            
            if(isset($s[0][0]) and is_array($s[0][0])) {
                $clause = $s[0];
            } else {
                $clause = $s;
            }

        }

        foreach ($clause as $key => $value) {
            if(count($value) == 2) {
                $clause[$key][2] = $clause[$key][1];
                $clause[$key][1] = '=';
            }

            $param_name = $clause[$key][0] . '_' . Misc::generate_random_string(3);
            $clause_string['queries'][] = " $o {$clause[$key][0]} {$clause[$key][1]} :{$param_name}";
            $clause_string['params'][$param_name] = $clause[$key][2];

        }

        $this->where["queries"] = array_merge($this->where["queries"], $clause_string["queries"]);
        $this->where["params"] = array_merge($this->where["params"], $clause_string["params"]);
    }

    public function where(...$s)
    {
        $this->where_do('AND', $s);

        return $this;
    }

    public function and_where(...$s)
    {
        $this->where_do('AND', $s);

        return $this;
    }

    public function or_where(...$s) 
    {
        $this->where_do('OR', $s);

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

        $this->add_query('SELECT ' . implode(', ', $s) . ' FROM {{table}} {{where}}');
        
        return $this;
    }

    public function first(...$s)
    {
        $this->select(...$s);
        $this->fetch = 2;

        return $this;
    }
}