<?php

class User
{
    public $username;
    public $timeJoined;
    public $url;

    function __construct()
    {
        $this->url = "https://img.zrmiller.com/u/" . $this->username;
    }
}
