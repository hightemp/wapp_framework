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
    public $aSession = [];
    public $sInput = "";

    public static $sCurrentAlias = "";
    public static $sCurrentModuleClass = "";
    public static $sCurrentControllerClass = "";
    public static $sCurrentMethod = "";

    public function __construct(
        &$aRequest=[],
        &$aGet=[], 
        &$aPost=[], 
        &$aFiles=[],
        &$aCookie=[],
        &$aServer=[],
        &$aSession=[]
    )
    {
        $this->aRequest = &$aRequest;
        $this->aGet = &$aGet;
        $this->aPost = &$aPost;
        $this->aFiles = &$aFiles;
        $this->aCookie = &$aCookie;
        $this->aServer = &$aServer;
        $this->aSession = &$aSession;
        $this->fnGetInput();
    }

    public static function fnBuild()
    {
        return new static(
            $_REQUEST,
            $_GET, 
            $_POST, 
            $_FILES,
            $_COOKIE,
            $_SERVER,
            $_SESSION
        );
    }

    public function fnGetInput()
    {
        return $this->sInput = ($this->sInput ?: file_get_contents("php://input"));
    }

    public function fnGetJSON()
    {
        return json_decode($this->sInput, true);
    }
}