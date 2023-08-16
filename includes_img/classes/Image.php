<?php

class Image
{
    public $author;
    public $uuid;
    public $extension;
    public $thumbnail;
    public $animated;
    public $timeUploaded;
    public $url;
    public $thumbnailURL;

    function __construct()
    {
        $this->thumbnail = $this->thumbnail == 1;
        $this->animated = $this->animated == 1;
        $this->url = "https://img.zrmiller.com/i/" . $this->uuid . "." . $this->extension;
        $this->thumbnailURL = "https://img.zrmiller.com/i/" . $this->uuid . "_thumbnail." . $this->extension;
    }
}

class ImageSimple{
    public $author;
    public $uuid;
    public $extension;
    public $url;

    function __construct()
    {
        $this->url = "https://img.zrmiller.com/i/" . $this->uuid . "." . $this->extension;
    }

}