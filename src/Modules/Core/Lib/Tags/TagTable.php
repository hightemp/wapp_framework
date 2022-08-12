<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Tags;

class TagTable
{
    public function __invoke($aData, $sClass="", $sID="")
    {
        $sHTML = "";

        foreach ($aData as $aRow) {
            $sHTML .= "<tr>";
            foreach ($aRow as $sCell) {
                $sHTML .= "<td>";
                $sHTML .= $sCell;
                $sHTML .= "</td>";
            }
            $sHTML .= "</tr>";
        }

        $sHTML = "<table>{$sHTML}</table>";
        
        echo $sHTML;
    }
}