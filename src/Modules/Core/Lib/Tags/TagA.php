<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Tags;

class TagA
{
    public function __invoke($sContent, $sHref, $sTitle="", $sClass="", $sName="", $sID="")
    {
        echo "<a href=\"{$sHref}\" title=\"{$sTitle}\" class=\"{$sClass}\" id=\"{$sID}\" name=\"{$sName}\">{$sContent}</a>";
    }
}