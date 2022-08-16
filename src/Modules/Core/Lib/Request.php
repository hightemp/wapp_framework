<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib;

class Request
{
    public $aRequest = [];
    public $aGet = [];
    public $aPost = [];
    public $aFiles = [];
    public $aCookie = [];
    public $aServer = [];

    public static $sCurrentAlias = "";
    public static $sCurrentModuleClass = "";
    public static $sCurrentControllerClass = "";
    public static $sCurrentMethod = "";

    public function __construct(
        $aRequest=[],
        $aGet=[], 
        $aPost=[], 
        $aFiles=[],
        $aCookie=[],
        $aServer=[]
    )
    {
        $this->aRequest = $aRequest;
        $this->aGet = $aGet;
        $this->aPost = $aPost;
        $this->aFiles = $aFiles;
        $this->aCookie = $aCookie;
        $this->aServer = $aServer;
    }

    public static function fnCreateRequest()
    {
        return new static(
            $_REQUEST,
            $_GET, 
            $_POST, 
            $_FILES,
            $_COOKIE,
            $_SERVER
        );
    }
}