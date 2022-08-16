<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib;

class BaseGenerator
{
    const TEMPLATES_PATH = ROOT_PATH."/src/templates";
    const GENERATOR_TYPE = "";

    public static $aDefaultOptions = [
        "templates" => [

        ],
        "vars" => [

        ],
        "args" => [

        ],
    ];
    
    /**
     * Массовая генерация файлов по параматрам из общих переменных
     *
     * @param  array $aOptions
     * @return void
     */
    public static function fnGenerate($aArgs=[], $aOptions=[])
    {
        $aOptions = array_merge_recursive(static::$aDefaultOptions, $aOptions);
        $aOptions["args"] = $aArgs;

        $aOptions["vars"]["root_path"] = ROOT_PATH;
        $aOptions["vars"]["global_templates_path"] = static::TEMPLATES_PATH;
        $aOptions["vars"] = array_merge_recursive($aOptions["vars"], $aArgs);

        static::fnPrepareVars($aOptions["vars"]);

        foreach ($aOptions["templates"] as $sSrc => $sDest) {
            static::fnGenerateFile($sSrc, $sDest, $aOptions["vars"]);
        }
    }

    public static function fnPrepareVars(&$aVars)
    {
        
    }

    public static function fnHook_Before_GenerateFile(&$sTemplate, &$sOutputFile, &$aVars)
    {

    }

    public static function fnHook_After_GenerateFile($sTemplate, $sOutputFile, $aVars)
    {
        
    }

    public static function fnGenerateFile($sTemplate, $sOutputFile, $aVars)
    {
        static::fnHook_Before_GenerateFile($sTemplate, $sOutputFile, $aVars);

        $sTemplatePath = static::TEMPLATES_PATH."/".$sTemplate;
        $sOutputPath = $sOutputFile;

        $sTemplateContent = file_get_contents($sTemplatePath);

        $sOutputContent = preg_replace_callback(
            "/\{\{(.*?)\}\}/", 
            function ($aM) use ($aVars) {
                return $aVars[$aM[1]] ?? '';
            },
            $sTemplateContent
        );

        $sOutputPath = preg_replace_callback(
            "/\{\{(.*?)\}\}/", 
            function ($aM) use ($aVars) {
                return $aVars[$aM[1]] ?? '';
            },
            $sOutputPath
        );

        file_put_contents($sOutputPath, $sOutputContent);

        echo "[>] $sOutputPath\n";

        static::fnHook_Before_GenerateFile($sTemplatePath, $sOutputPath, $sOutputContent);
    }
}