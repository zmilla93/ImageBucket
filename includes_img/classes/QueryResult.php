<?php

// Acts as a simplified wrapper for a PDOStatement
class QueryResult
{
    public $rowCount;
    public $data;
    public $success = true;

    function __construct($rowCount, $data)
    {
        $this->rowCount = $rowCount;
        $this->data = $data;
        if ($data == false) $this->success = false;
    }

    static function singleRow($stmt)
    {
        return new QueryResult($stmt->rowCount(), $stmt->fetch());
    }

    static function multipleRows($stmt)
    {
        return new QueryResult($stmt->rowCount(), $stmt->fetchAll());
    }
}
