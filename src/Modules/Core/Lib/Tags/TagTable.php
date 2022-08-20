<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;

class TagTable extends BaseTag
{
    public function __invoke($aData, $aHeaders=[], $aAttr=[])
    {
        $sHTML = "";

        if ($aHeaders) {
            $sHTML .= "<thead>\n";
            $sHTML .= "<tr>\n";
            foreach ($aHeaders as $mHeader) {
                $sCell = is_string($mHeader) ? $mHeader : $mHeader[0];
                $sAttr = is_string($mHeader) ? '' : static::fnPrepareAttrString($mHeader[1]);
                $sHTML .= "<th {$sAttr}>\n";
                $sHTML .= $sCell;
                $sHTML .= "\n</th>\n";
            }
            $sHTML .= "</tr>\n";
            $sHTML .= "</thead>\n";
        }

        $sHTML .= "<tbody>\n";
        foreach ($aData as $aRow) {
            $sHTML .= "<tr>\n";
            foreach ($aHeaders as $iI => $mHeader) {
                $sCell = isset($aRow[$iI]) ? $aRow[$iI] : '';
                $sHTML .= "<td>\n";
                $sHTML .= $sCell;
                $sHTML .= "\n</td\n>";
            }
            $sHTML .= "</tr>\n";
        }
        $sHTML .= "</tbody>\n";

        $sAttr = static::fnPrepareAttrString($aAttr);

        $sHTML = "<table {$sAttr}>\n{$sHTML}</table>\n";
        
        static::fnPrint($sHTML);
    }
}