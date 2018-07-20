<?php
 namespace Core;


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
        $query .= " FROM " . $this->getTable();

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
                $offset .= " OFFSET " . $this->offset;
            }
        }
        global $pdh;
//        dd($sql);
        $statement = $pdh->query($query);
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
        global $pdh;
        $fields = implode(', ', array_keys($this->attributes));
        $values = implode(', ', array_map(function($item) use ($pdh) {
            return $pdh->quote($item);
        }, $this->attributes));
        $tableName = $this->getTable();
        $sql = "INSERT INTO $tableName ($fields) VALUES ($values)";
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

    public function set($value1, $value2)
    {
        $this->set = " SET $value1='$value2' ";
        return $this;
    }

    public function update($table)
    {
        $sql = "UPDATE $table" . $this->set . "WHERE " . $this->where . ";";
        query($sql);
    }

    public function join($to, $with, $operator = "=", $onWith){
        $this->join= " JOIN $to ON $with $operator $onWith ";
        return $this;
    }

    public function showColumns()
    {
        $sql = "show columns FROM $this->table ;";
//        dd($sql);
        return query($sql);
    }




}
