<?php

namespace Hightemp\WappFramework\Modules\Core\Lib;

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

    public function fnPrepareDatabasePath($sRelPath)
    {
        return preg_replace("@^./@", ROOT_PATH."/", $sRelPath);
    }

    public function fnPrepareDSN()
    {
        if ($this->sDSN) return $this->sDSN;

        $this->sDB = $this->fnPrepareDatabasePath($this->sDB);

        $this->sDSN = $this->sProtocol.":";

        if ($this->sDB && $this->sProtocol!="sqlite") $this->sDSN .= "dbname=".$this->sDB;
        if ($this->sDB && $this->sProtocol=="sqlite") $this->sDSN .= $this->sDB;
        if ($this->sHost) $this->sDSN .= ";host=".$this->sHost;
        if ($this->sPort) $this->sDSN .= ";port=".$this->sPort;
        if ($this->sSocket) $this->sDSN .= ";unix_socket=".$this->sSocket;
        if ($this->sCharset) $this->sDSN .= ";charset=".$this->sCharset;

        return $this->sDSN;
    }

    public static function fnBuildFromConfig($sKey)
    {
        $oO = new DatabaseConnectionOptions();

        $aDB = Config::$aConfig["aDatabase"][$sKey];

        $oO->sProtocol = $aDB["DATABASE_PROTOCOL"];
        $oO->sDB = $aDB["DATABASE_DB"];
        $oO->sHost = $aDB["DATABASE_HOST"];
        $oO->sPort = $aDB["DATABASE_PORT"];
        $oO->sSocket = $aDB["DATABASE_SOCKET"];
        $oO->sCharset = $aDB["DATABASE_CHARSET"];
        $oO->sUser = $aDB["DATABASE_USER"];
        $oO->sPassword = $aDB["DATABASE_PASSWORD"];

        return $oO;
    }
}