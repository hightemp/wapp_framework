<?php

namespace Hightemp\WappTestSnotes\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Tags\TagTable;

class TagCEDatagrid extends BaseTag
{
    public static $aDefaultAttrs = [
        "class" => "easyui-datagrid",
        "label" => "Datagrid",
        "labelPosition" => "top",
        "style" => "width:100%;height:100%",
        "data-options" => "singleSelect:true,collapsible:true,fit:true,nowrap:false"
    ];

    public function __invoke($aData=[], $aHeaders=[], $aAttr=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttr, static::$aDefaultAttrs);

        $aNewHeaders = [];
        foreach ($aHeaders as $sHead) {
            if (is_string($sHead)) {
                $aNewHeaders[$sHead] = [
                    $sHead,
                    [
                        "field" => $sHead
                    ]
                ];
            }
        }

        (new TagTable())($aData, $aNewHeaders, $aAttrs);
    }
}