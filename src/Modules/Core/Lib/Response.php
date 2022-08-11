<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib;

class Response
{
    public $sContent = "";
    public $iCode = 200;
    public $sContentType = "text/plain";

    public function fnSetContent($sContent)
    {
        $this->sContent = $sContent;
    }

    public function fnGetContent()
    {
        return $this->sContent;
    }

    public function fnPrintOutputAndExit()
    {
        header("Content-Type: {$this->sContentType}");
        http_response_code($this->iCode);
        die($this->fnGetContent());
    }
}