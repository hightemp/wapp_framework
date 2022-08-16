<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;

class TagTable extends BaseTag
{
    public function __invoke($aData, $aHeaders=[], $aAttr=[])
    {
        $sHTML = "";

        if ($aHeaders) {
            $sHTML .= "<thead>";
            $sHTML .= "<tr>";
            foreach ($aHeaders as $mHeader) {
                $sCell = is_string($mHeader) ? $mHeader : $mHeader[0];
                $sAttr = is_string($mHeader) ? '' : static::fnPrepareAttr($mHeader[1]);
                $sHTML .= "<th {$sAttr}>";
                $sHTML .= $sCell;
                $sHTML .= "</th>";
            }
            $sHTML .= "</tr>";
            $sHTML .= "</thead>";
        }

        $sHTML .= "<tbody>";
        foreach ($aData as $aRow) {
            $sHTML .= "<tr>";
            foreach ($aHeaders as $iI => $mHeader) {
                $sCell = isset($aRow[$iI]) ?: '';
                $sHTML .= "<td>";
                $sHTML .= $sCell;
                $sHTML .= "</td>";
            }
            $sHTML .= "</tr>";
        }
        $sHTML .= "</tbody>";

        $sAttr = static::fnPrepareAttr($aAttr);

        $sHTML = "<table {$sAttr}>{$sHTML}</table>";
        
        echo $sHTML;
    }
}