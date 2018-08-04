<?php
 namespace Core;
 use PDO;



class ORM
{
    protected static $connection;

    protected $select;

    protected $order;

    protected $where;

    protected $limit;

    protected $offset;

    protected $set;

    protected $join;

    protected $from;

    protected $selectFrom;

    protected $show;

    protected $table;

    public $attributes = [];

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function __get($key)
    {
        return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
    }

    private function execute()
    {
        $query = "SELECT ";
        if ($this->select) {
            $query .= $this->select . ' ';
        } else {
            $query .= " * ";
        }

        if ($this->table){
            $query.= " FROM " . $this->table;
        }else{
            $query .= " FROM " . $this->getTable();
        }



        if($this->from) {
            $query .= $this->from;
        }

        if ($this->join) {
            $query .= $this->join;
        }

        if ($this->where) {
            $query .= " WHERE " . $this->where;
        }

        if ($this->order) {
            $query .= " ORDER BY " . $this->order;
        }

        if ($this->limit) {
            $query .= " LIMIT " . $this->limit;
            if ($this->offset) {
                $query .= " OFFSET " . $this->offset;
            }
        }
        global $pdh;
        /** @var PDO $pdh */


        $statement = $pdh->query($query);
//        dd($statement);
//        dd($query);
        if (!$statement) {
            echo "\nPDO::errorInfo():\n";
            print_r($pdh->errorInfo());
            dd($query);
        }
        return $statement->fetchAll(\PDO::FETCH_CLASS, static::class);
    }

    public function getTable()
    {
        if (property_exists($this, 'table')) {
            return $this->table;
        } else {
            $className = static::class;
            $parts = explode('\\', $className);
            return strtolower($parts[count($parts)-1]);
        }
    }

    public function get()
    {
        return $this->execute();
    }


    public function toArray()
    {
        $execute = $this->execute();

        $result = [];

        foreach ($execute as $data) {
            $result[] = $data->attributes;
        }

        return $result;
    }

    public function first()
    {
        $this->limit(1);
        $model = $this->execute();
        if (count($model)) {
            return $model[0];
        }
        return null;
    }

    public function select($columns)
    {
        $this->select = $columns;
        return $this;
    }

    public function doubleSelect($columns)
    {
        $this->select .= $columns;
        return $this;
    }

    public function where($condition)
    {
        $this->where = $condition;
        return $this;
    }

    public function order($order)
    {
        $this->order = $order;
        return $this;
    }

    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    public function insert()
    {
        /** @var PDO $pdh */


        global $pdh;
        $fields = implode(', ', array_keys($this->attributes));
        $values = implode(', ', array_map(function($item) use ($pdh) {

            return $pdh->quote($item);
        }, $this->attributes));
        $tableName = $this->getTable();
        $sql = "INSERT INTO $tableName ($fields) VALUES ($values);";
//        dd($sql);
        query($sql);
    }

    public function delete()
    {
        $tableName = $this->getTable();
        $sql = "DELETE FROM $tableName";
        if ($this->where) {
            $sql .= " WHERE " . $this->where;
        }
        query($sql);
    }

    public function set($value1 = [], $value2= [])
    {
        $txt = '';
        for($i = 0; $i< count($value1) ;$i++) {
            $txt .= $value1[$i] ."=". "'".$value2[$i]."'" . ",";
        }
        $txt = substr($txt , 0,-1);
        $this->set = " SET $txt ";
        return $this;
    }

    public function update()
    {

        $sql = "UPDATE $this->table" . $this->set . "WHERE " . $this->where . ";";
        query($sql);
    }

    public function join($to, $with, $operator = "=", $onWith){
        $this->join = " LEFT JOIN $to ON $with $operator $onWith ";
        return $this;
    }

    public function doubleJoin($to, $with, $operator = "=", $onWith)
    {
        $this->join .= " LEFT JOIN $to ON $with $operator $onWith ";
        return $this;
    }

    public function showColumns()
    {
        $sql = "show.php columns FROM $this->table ;";
        return query($sql);
    }


    public function from($table, $as = '')
    {
        if(is_callable($table)) {
            return $table($this);
        }

        $this->from = '(SELECT ' . $this->selectFrom    . ' FROM ' . $table . $this->join . ') as ' . $as;

        return $this;
    }



}
