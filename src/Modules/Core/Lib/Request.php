<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib;

class Request
{
    public $aGet = [];
    public $aPost = [];
    public $aFiles = [];
    public $aCookie = [];
    public $aServer = [];

    public function __construct(
        $aGet=[], 
        $aPost=[], 
        $aFiles=[],
        $aCookie=[],
        $aServer=[]
    )
    {
        $this->aGet = $aGet;
        $this->aPost = $aPost;
        $this->aFiles = $aFiles;
        $this->aCookie = $aCookie;
        $this->aServer = $aServer;
    }

    public static function fnCreateRequest()
    {
        return new static(
            $_GET, 
            $_POST, 
            $_FILES,
            $_COOKIE,
            $_SERVER
        );
    }
}