<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib;

class DatabaseConnectionOptions
{
    public $sProtocol = "";
    public $sDB = "";
    public $sHost = "";
    public $sPort = "";
    public $sSocket = "";
    public $sCharset = "";

    public $sUser = "";
    public $sPassword = "";

    public $sDSN = "";

    // $sProtocol, $sDB, $sHost=null, $sPort=null, $sSocket=null, $sCharset=null

    public function fnPrepareDSN()
    {
        if ($this->sDSN) return $this->DSN;

        $this->sDSN = sprintf("%s:dbname=%s", $this->sProtocol, $this->sDB);
        if (!($this->sHost)) $this->sDSN .= ";host=".$this->sHost;
        if (!($this->sPort)) $this->sDSN .= ";port=".$this->sPort;
        if (!($this->sSocket)) $this->sDSN .= ";unix_socket=".$this->sSocket;
        if (!($this->sCharset)) $this->sDSN .= ";charset=".$this->sCharset;
        return $this->sDSN;
    }
}