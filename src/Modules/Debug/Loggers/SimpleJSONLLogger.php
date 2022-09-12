<?php

namespace Hightemp\WappFramework\Modules\Debug\Loggers;

use Hightemp\WappFramework\Modules\Core\Lib\Config;
use Hightemp\WappFramework\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappFramework\Modules\Core\Lib\BaseLogger;
use Hightemp\WappFramework\Modules\Core\Lib\Request;

class SimpleJSONLLogger extends BaseLogger
{
    public $sLoggerPath = "";
    public $sFileName = "";
    public $sLoggerFilePath = "";
    public $oRequest = null;
    public $bHeaderWritten = false;
    
    /**
     * fnBuild
     * 
     * @uses Config::$aConfig
     * @uses BaseController::$oGlobalRequest
     *
     * @return void
     */
    public static function fnBuild()
    {
        $sLoggerPath = Config::$aConfig["sLoggerPath"];
        $sFileName = time().".jsonl";
        return (static::$oInstance = new SimpleJSONLLogger($sLoggerPath, $sFileName));
    }
    
    /**
     * __construct
     * 
     * @param string $sLoggerPath
     * @param string $sFileName
     * @param Request $oRequest
     *
     * @return void
     */
    public function __construct(
        $sLoggerPath,
        $sFileName,
        $oRequest = null
    )
    {
        $this->sLoggerPath = $sLoggerPath;
        $this->sFileName = $sFileName;
        $this->sLoggerFilePath = $sLoggerPath."/".$sFileName;
        $this->oRequest = $oRequest;

        $this->fnUpdateHeaderByRequest();
    }
    
    /**
     * fnUpdateHeaderByRequest
     *
     * @uses BaseController::$oGlobalRequest
     * 
     * @return void
     */
    public function fnUpdateHeaderByRequest()
    {
        if (!$this->oRequest && !BaseController::$oGlobalRequest) {
            // NOTE: Если запроса нет оставляем пустым заголовок в логе до его появления
            $this->fnUpdateHeader([]);
            return;
        }

        if (!$this->oRequest) {
            $this->oRequest = BaseController::$oGlobalRequest;
        }
        
        $this->fnUpdateHeader([
            "iTimestamp" => $this->oRequest->iTimestamp,
            "aGet" => $this->oRequest->aGet,
            "aPost" => $this->oRequest->aPost,
            "aFiles" => $this->oRequest->aFiles,
            "aCookie" => $this->oRequest->aCookie,
            "aServer" => $this->oRequest->aServer,
            "aSession" => $this->oRequest->aSession,
        ]);
    }

    public function fnUpdateHeader($aData)
    {
        $rH = fopen($this->sLoggerFilePath, "w+");
        fseek($rH, 0);
        $sJSON = json_encode($aData)."\n";
        fwrite($rH, $sJSON, 1000);
        fclose($rH);
    }

    public function fnWrite($sMessage, $aData=[])
    {
        $sJSON = json_encode([microtime(), date("Y-m-d H:i:s"), $sMessage, $aData])."\n";
        file_put_contents($this->sLoggerFilePath, $sJSON, FILE_APPEND);
    }
}