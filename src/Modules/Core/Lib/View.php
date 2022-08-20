<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib;

use Hightemp\WappTestSnotes\Modules\Core\Helpers\Utils;
use Hightemp\WappTestSnotes\Project;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Tags\{
    TagA,
    TagAliasA,
    TagTable,
    TagInclude,
    TagSelect,
    TagFormBegin,
    TagFormEnd,
    TagScript,
    TagLink,
};

class View
{
    const STATIC_PATH = "static";
    const STATIC_IMAGES_PATH = "static/images";
    const STATIC_CSS_PATH = "static/css";
    const STATIC_JS_PATH = "static/js";

    const TEMPLATES_PATH = "views";

    const THEME = "";

    public static $sCurrentViewClass = null;

    public static $sLayoutTemplate = "layout.php";
    public static $sContentTemplate = "index.php";
    public static $sHeaderTemplate = "header.php";

    /** @var string[] $aVars Список переменных. Ключ - значение */
    public static $aVars = [];
    /** @var string $sHTMLHeader Это код html->head блока */
    public static $sHTMLHeader = '';

    /** 
     * @var string[][] $aTemplates список классов соотнесенных с шаблонами 
     *  
     * ```php
     * [
     *      Controller::class => [
     *          "fnIndexHTML" => ['content_page.php', 'layout.php']
     *      ]
     * ]
     * ``` 
     **/
    public static $aTemplates = [];

    public static function fnGetModuleRelPath($sExtPath="")
    {
        return Utils::fnGetRelPathForClassModule(static::class, "/".$sExtPath);
    }

    public static function fnGetModuleGlobalPath($sExtPath="")
    {
        return Utils::fnGetGlobalPathForClassModule(static::class, "/".$sExtPath);
    }

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
        self::$aVars['oTagSelect'] = new TagSelect();
        self::$aVars['oTagFormBegin'] = new TagFormBegin();
        self::$aVars['oTagFormEnd'] = new TagFormEnd();

        self::$aVars['oTagScript'] = new TagScript();
        self::$aVars['oTagLink'] = new TagLink();
        
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

    public static function fnSetParams($aVarsToAdd=[], $sContentTemplate=null, $sLayoutTemplate=null)
    {
        if ($aVarsToAdd) static::fnAddVars($aVarsToAdd);
        if ($sContentTemplate) static::$sContentTemplate = $sContentTemplate;
        if ($sLayoutTemplate) static::$sLayoutTemplate = $sLayoutTemplate;
    }

    public static function fnAddHeaderFavicon($sRelFilePath="favicon.png", $sType="png")
    {
        static::fnAddHTMLHeader(static::fnRenderLinkFavicon($sRelFilePath, $sType));
    }

    public static function fnRenderLinkFavicon($sRelFilePath="", $sType=null)
    {
        if (is_null($sType)) $sType = "x-icon";
        $sRelFilePath = static::fnGetImagesPath("/".$sRelFilePath);
        $sHTML = <<<EOF
<link rel="icon" type="image/{$sType}" href="{$sRelFilePath}">
EOF;
        return $sHTML;
    }

    public static function fnGetImagesPath($sExtPath="")
    {
        return static::fnGetModuleRelPath(static::STATIC_IMAGES_PATH.$sExtPath);
    }

    public static function fnGetCSSPath($sExtPath="")
    {
        return static::fnGetModuleRelPath(static::STATIC_CSS_PATH.$sExtPath);
    }

    public static function fnAddHeaderCSS($sRelFilePath)
    {
        static::fnAddHTMLHeader(static::fnRenderLinkStylesheet($sRelFilePath));
    }

    public static function fnRenderLinkStylesheet($sRelFilePath)
    {
        $sRelFilePath = static::fnGetCSSPath("/".$sRelFilePath);
        $sHTML = <<<EOF
<link rel="stylesheet" href="{$sRelFilePath}">\n
EOF;
        return $sHTML;
    }

    public static function fnGetJSPath($sExtPath="")
    {
        return static::fnGetModuleRelPath(static::STATIC_JS_PATH.$sExtPath);
    }

    public static function fnAddHeaderJS($sRelFilePath)
    {
        static::fnAddHTMLHeader(static::fnRenderScript($sRelFilePath));
    }

    public static function fnRenderScript($sRelFilePath)
    {
        $sRelFilePath = static::fnGetJSPath("/".$sRelFilePath);
        $sHTML = <<<EOF
<script src="{$sRelFilePath}"></script>\n
EOF;
        return $sHTML;
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

    public static function fnGetTemplatesPath($sExtPath="")
    {
        return static::fnGetModuleGlobalPath(static::TEMPLATES_PATH.$sExtPath);
    }

    public static function fnIsTemplate($sTemplatePath)
    {
        return is_file(static::fnGetTemplatesPath("/".$sTemplatePath));
    }

    public static function fnRenderTemplate($sTemplatePath, $aVars=[])
    {
        static::$sCurrentViewClass = static::class;
        $aVars['sCurrentViewClass'] = static::$sCurrentViewClass;

        if ($aVars) static::fnAddVars($aVars);
        ob_start();
        {
            extract(self::$aVars);
            require_once(static::fnGetTemplatesPath("/".$sTemplatePath));
        }
        return ob_get_clean();
    }
}