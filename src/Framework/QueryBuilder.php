<?php

namespace Framework;
use Framework\MyPDO;
class QueryBuilder
{
    private $connection;
    private $table;
    private $params;
    private $column;
    private $order;
    private $limit;

    function __construct()
    {
        $this->connection= new MyPDO();
    }
    public function From($table){
        $this->table=$table;
    }
    public function Where($params){
        $this->params=$params;
    }
    public function OrderBy($column, $order){
        $this->column=$column;
        $this->order=$order;
    }
    public function Limit($limit){
        $this->limit = $limit;
    }

    private function ParamsValidator($param, $clause){
        if ($param == null){
             return "";
        }
        else{
            return " ".$clause." ".$param;
        }
    }

    public function Select($columns="*"){
        $where = $this->ParamsValidator($this->params, "WHERE");
        $column = $this->ParamsValidator($this->column, "ORDER BY");
        $order = $this->ParamsValidator($this->order, " ");
        $limit = $this->ParamsValidator($this->limit, "LIMIT");
        $table = $this->ParamsValidator($this->table, "FROM");
        $sql="SELECT ".$columns.$table.$where.$column.$order.$limit;
        $sth = $this->connection->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll();
        return $result;
    }

    public function Insert($table, $data){
        $columns="";
        $values = "";

        while ($index = current($data)) {
            $colmn = key($data);
            $value = $data[key($data)];

            if ($columns == ""){
                $columns = $colmn;
                if(gettype($value)=="string"){
                    $values = "'".$value."'";
                }
                else{
                    $values = $value;
                }

            }
            else{
                $columns = $columns.", ". $colmn;
                if(gettype($value)=="string"){
                    $values = $values.", "."'". $value."'";
                }
                else{
                    $values = $values.", ". $value;
                }
            }
            next($data);
        }
        $sql = "INSERT INTO $table ($columns) VALUES ($values);";
        $sth = $this->connection->prepare($sql);
        $sth->execute();
    }

    function __destruct()
    {
        $this->connection = null;

    }
}