<?php

abstract class DB 
{   

    private $host;
    private $user;
    private $pwrd;
    private $dbsa;
    private $where;
    private $connection;
    protected $table;

    public function __construct($class)
    {
        $this->host = HOST;
        $this->user = USER;
        $this->pwrd = PWRD;
        $this->dbsa = DBSA;
        $this->port = PORT;

        $this->setTableName($class);
        $this->getConnection();
    }

    public function where ($column, $value)
    {       
        $this->where = " WHERE $column = '$value'";
        return $this;
    }

    public function andWhere ($column, $value)
    {       
        $this->where .= " AND $column = '$value'";
        return $this;
    }

    public function orWhere ($column, $value)
    {       
        $this->where .= " OR $column = '$value'";
        return $this;
    }

    public function all ($columns = null)
    {
        if ($columns != null) {
            $columns = implode(", ", $columns);
        } else {
            $columns = "*";
        }
        $sql = "SELECT {$columns} FROM {$this->table} {$this->where} ORDER BY id DESC";
        return $this->connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get ($columns = null)
    {
        if ($columns != null) {
            $columns = implode(", ", $columns);
        } else {
            $columns = "*";
        }
        $sql = "SELECT {$columns} FROM {$this->table} {$this->where} ORDER BY id DESC";

        $return = $this->connection->query($sql);
        if ( !$return ) {
            return [];
        }
        return $return->fetch(PDO::FETCH_OBJ);
    }

    public function find ($id, $columns = null)
    {
        if ($columns != null) {
            $columns = implode(", ", $columns);
        } else {
            $columns = "*";
        }
        $sql = "SELECT {$columns} FROM {$this->table} WHERE id = '{$id}' LIMIT 1";
        return  $this->connection->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    public function save ($data)
    {
        if ( !is_array($data)) {
            Utils::json_dd(['return' => 'error', 'message' => 'É preciso definir os dados para salvar']);
        }
        $columns = "(".implode(", ", array_keys($data)).")";
        $values  = "('".implode("', '", array_values($data))."')";
        $sql = "INSERT INTO {$this->table} {$columns} VALUES {$values}";
        
        if ( !$this->connection->query($sql) ) {
            return false;
        }

        return $this->all();
    }

    public function update ($id, $data)
    {
        $sql_values = [];
        foreach ($data as $column => $value) {
            array_push($sql_values, "{$column} = '{$value}'");
        }
        $sql_values = implode(", ", $sql_values);
        $sql = "UPDATE {$this->table} SET {$sql_values} WHERE id = {$id} LIMIT 1";

        if ( !$this->connection->query($sql) ) {
            return false;
        }
        return $this->all();
    }

    public function delete ($id)
    {
        $sql = "SELECT id FROM {$this->table} WHERE id = '{$id}' LIMIT 1";
        if ( $this->connection->query($sql)->fetch(PDO::FETCH_ASSOC) ) {
            $sql = "DELETE FROM {$this->table} WHERE id = '{$id}' LIMIT 1";
            if ($this->connection->query($sql)) {
                return $this->all();
            }
            return false;
        } else {
            return false;
        }
    }

    public function getConnection ()
    {
        if ( !$this->connection ) {
            $this->connection = new PDO("mysql:host={$this->host};port={$this->port}dbname={$this->dbsa}", $this->user, $this->pwrd);
        }
        return $this->connection;
    }

    protected function setTableName ($class)
    {
        if ( $this->table == "") {
            $this->table = $this->dbsa.'.'.strtolower($class).'s';
        }
    }

}