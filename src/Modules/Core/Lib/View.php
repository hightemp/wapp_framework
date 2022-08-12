<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Tags\TagA;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Tags\TagAliasA;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Tags\TagTable;

class View
{
    const STATIC_PATH = "";
    const TEMPLATES_PATH = "";
    public static $sLayoutTemplate = "layout.php";
    public static $sContentTemplate = "index.php";

    public static $aVars = [];

    public static function fnClearVars()
    {
        self::$aVars = [];
    }

    public static function fnPrepareVars()
    {
        self::$aVars['sStaticPath'] = static::STATIC_PATH;
        self::$aVars['oTagA'] = new TagA();
        self::$aVars['oTagAliasA'] = new TagAliasA();
        self::$aVars['oTagTable'] = new TagTable();
    }

    public static function fnAddVars($aVars)
    {
        self::$aVars = array_merge(self::$aVars, $aVars);
    }

    public static function fnSetParams($aVars=[], $sContentTemplate=null, $sLayoutTemplate=null)
    {
        static::fnAddVars($aVars);
        if ($sLayoutTemplate) static::$sLayoutTemplate = $sLayoutTemplate;
        if ($sContentTemplate) static::$sContentTemplate = $sContentTemplate;
    }

    public static function fnRender()
    {
        static::fnPrepareVars();
        return static::fnRenderLayout();
    }

    public static function fnRenderLayout($aVars=[])
    {
        return static::fnRenderTemplate(static::$sLayoutTemplate, $aVars);
    }

    public static function fnRenderContent($aVars=[])
    {
        return static::fnRenderTemplate(static::$sContentTemplate, $aVars);
    }

    public static function fnRenderTemplate($sTemplatePath, $aVars=[])
    {
        // $oSelf = static::fnGetInstance();
        static::fnAddVars($aVars);
        ob_start();
        {
            extract(self::$aVars);
            require_once(static::TEMPLATES_PATH."/".$sTemplatePath);
        }
        return ob_get_clean();
    }
}