<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib;

class BaseGenerator
{
    const TEMPLATES_PATH = "";
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
    public static function fnGenerate($aOptions, $aArgs=[])
    {
        $aOptions = array_merge_recursive(static::$aDefaultOptions, $aOptions);
        $aOptions["args"] = $aArgs;
        $aOptions["vars"] = array_merge_recursive($aOptions["vars"], $aArgs);

        foreach ($aOptions["templates"] as $sSrc => $sDest) {
            static::fnGenerateFile($sSrc, $sDest, $aOptions["vars"]);
        }
    }

    public static function fnGenerateFile($sTemplate, $sOutputFile, $aVars)
    {
        $sTemplatePath = static::TEMPLATES_PATH."/".$sTemplate;
        $sOutputPath = static::TEMPLATES_PATH."/".$sOutputFile;

        $sTemplateContent = file_get_contents($sTemplatePath);

        $sOutputContent = preg_replace_callback(
            "/\{\{(.*?)\}\}/", 
            function ($aM) use ($aVars) {
                return $aVars[$aM[1]];
            },
            $sTemplateContent
        );

        $sOutputPath = preg_replace_callback(
            "/\{\{(.*?)\}\}/", 
            function ($aM) use ($aVars) {
                return $aVars[$aM[1]];
            },
            $sOutputPath
        );

        file_put_contents($sOutputPath, $sOutputContent);
    }
}