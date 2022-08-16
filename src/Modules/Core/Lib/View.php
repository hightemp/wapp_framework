<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib;

use Hightemp\WappTestSnotes\Project;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Tags\TagA;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Tags\TagAliasA;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Tags\TagTable;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Tags\TagInclude;

class View
{
    const STATIC_PATH = "static";
    const STATIC_CSS_PATH = "static/css";
    const STATIC_JS_PATH = "static/js";

    const TEMPLATES_PATH = "";

    public static $sLayoutTemplate = "layout.php";
    public static $sContentTemplate = "index.php";
    public static $sHeaderTemplate = "header.php";

    public static $aVars = [];
    public static $sHTMLHeader = '';

    public static function fnClearVars()
    {
        self::$aVars = [];
    }

    public static function fnPrepareVars()
    {
        self::$aVars['sHTMLHeader'] = self::$sHTMLHeader;
        self::$aVars['sStaticPath'] = static::STATIC_PATH;
        isset(self::$aVars['sTitle']) ?: self::$aVars['sTitle'] = '';

        self::$aVars['oTagA'] = new TagA();
        self::$aVars['oTagAliasA'] = new TagAliasA();
        self::$aVars['oTagTable'] = new TagTable();

        self::$aVars['oInclude'] = new TagInclude(static::class);
    }

    public static function fnPrepareContentVar($sContentTemplate=null)
    {
        isset(self::$aVars['sContent']) ?: self::$aVars['sContent'] = static::fnRenderContent($sContentTemplate);
    }

    public static function fnAddVars($aVars)
    {
        self::$aVars = array_merge(self::$aVars, $aVars);
    }

    public static function fnPrepareHTMLHeader()
    {
        if (static::fnIsTemplate(static::$sHeaderTemplate)) {
            $sT = static::fnRenderTemplate(static::$sHeaderTemplate);
            self::$sHTMLHeader .= $sT;
        }
    }

    public static function fnAddHTMLHeader($sHTML)
    {
        self::$sHTMLHeader += $sHTML;
    }

    public static function fnSetParams($aVars=[], $sContentTemplate=null, $sLayoutTemplate=null)
    {
        static::fnAddVars($aVars);
        if ($sLayoutTemplate) static::$sLayoutTemplate = $sLayoutTemplate;
        if ($sContentTemplate) static::$sContentTemplate = $sContentTemplate;
    }

    public static function fnAddHeaderCSS($sRelFilePath)
    {
        $sRelFilePath = static::STATIC_CSS_PATH."/".$sRelFilePath;
        $sHTML = <<<EOF
<link rel="stylesheet" href="{$sRelFilePath}">\n
EOF;
        static::fnAddHTMLHeader($sHTML);
    }

    public static function fnAddHeaderJS($sRelFilePath)
    {
        $sRelFilePath = static::STATIC_JS_PATH."/".$sRelFilePath;
        $sHTML = <<<EOF
<script src="{$sRelFilePath}"></script>\n
EOF;
        static::fnAddHTMLHeader($sHTML);
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

    public static function fnRenderContent($sContentTemplate=null, $aVars=[])
    {
        if (is_null($sContentTemplate)) {
            if (static::fnIsTemplate(static::$sContentTemplate)) {
                return static::fnRenderTemplate(static::$sContentTemplate, $aVars);
            }
        } else {
            if (static::fnIsTemplate($sContentTemplate)) {
                return static::fnRenderTemplate($sContentTemplate, $aVars);
            }
        }
    }

    public static function fnIsTemplate($sTemplatePath)
    {
        return is_file(static::TEMPLATES_PATH."/".$sTemplatePath);
    }

    public static function fnRenderTemplate($sTemplatePath, $aVars=[])
    {
        if ($aVars) static::fnAddVars($aVars);
        ob_start();
        {
            extract(self::$aVars);
            require_once(static::TEMPLATES_PATH."/".$sTemplatePath);
        }
        return ob_get_clean();
    }

    public static function fnFindViewClassByName($sName)
    {
        foreach (Project::$aModules as $sModule) {
            
        }
    }
}