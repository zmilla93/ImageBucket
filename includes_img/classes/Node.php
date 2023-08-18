<?php

define("DIV", "div");
define("SPAN", "span");

class Node
{
    private $tag;
    public $id;
    public $classList = [];
    public $children = [];
    public $innerHTML;
    public $code = false;

    function __construct($tag = "div", $idOrClassList = null)
    {
        $this->tag = $tag;
        if ($idOrClassList != null) {
            if (is_array($idOrClassList)) {
                $this->classList = $idOrClassList;
            } else {
                $this->id = $idOrClassList;
            }
        }
    }

    function addClass($class)
    {
        array_push($this->classList, $class);
    }

    function addChild($child)
    {
        array_push($this->children, $child);
    }

    function addChildren(...$children)
    {
        foreach ($children as $child) {
            array_push($this->children, $child);
        }
    }

    function output()
    {
        echo "<" . $this->tag;
        if ($this->id != null) echo ' id="' . $this->id . '"';
        $classCount = count($this->classList);
        if ($classCount > 0) {
            echo ' class="';
            $i = 0;
            foreach ($this->classList as $class) {
                echo $class;
                $i++;
                if ($i < $classCount) echo " ";
            }
            echo '"';
        }
        echo ">";
        if ($this->code) echo "<code>";
        if ($this->innerHTML != null) echo $this->innerHTML;
        if ($this->code) echo "</code>";
        foreach ($this->children as $child) {
            $child->output();
        }
        echo "</" . $this->tag . ">";
    }
}

class Div extends Node
{
    function __construct($idOrClassList = null)
    {
        parent::__construct(DIV, $idOrClassList);
    }
}

class Span extends Node
{
    function __construct($idOrClassList = null)
    {
        parent::__construct(SPAN, $idOrClassList);
    }
}

class CodeSpan extends Node
{
    function __construct($idOrClassList = null)
    {
        parent::__construct(SPAN, $idOrClassList);
        $this->code = true;
    }
}
