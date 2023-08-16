<?php

// Acts as a simplified wrapper for a PDOStatement
class QueryResult
{
    public $rowCount;
    public $data;
    public $success = true;

    function __construct($stmt, $data)
    {
        $this->rowCount = $stmt->rowCount();
        $this->data = $data;
        if ($data == false || $this->rowCount == 0) $this->success = false;
    }

    static function singleRow($stmt)
    {
        return new QueryResult($stmt, $stmt->fetch(PDO::FETCH_ASSOC));
    }

    static function multipleRows($stmt)
    {
        return new QueryResult($stmt, $stmt->fetchAll(PDO::FETCH_ASSOC));
    }
}
