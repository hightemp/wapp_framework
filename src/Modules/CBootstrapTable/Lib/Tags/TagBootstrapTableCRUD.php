<?php

namespace Hightemp\WappTestSnotes\Modules\CBootstrapTable\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Tags\TagTable;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Tags\TagDivGrid;
use Hightemp\WappTestSnotes\Modules\CBootstrapTable\Lib\Tags\TagPagination;
use Hightemp\WappTestSnotes\Modules\CBootstrapTable\Lib\Tags\TagBootstrapTable;

class TagBootstrapTableCRUD extends BaseTag
{
    public function __invoke($aEntity)
    {
        $aData = $aEntity["aData"];
        $aHeaders = $aEntity["aHeaders"];
        $aAttrs = $aEntity["aAttrs"];
        $aURLs = $aEntity["aURLs"];

        $aAttrs["class"] = "table table-striped table-bordered";

        $oTagTable = new TagTable();
        $oTagPagination = new TagPagination();
        $oTagDivGrid = new TagDivGrid();

        $oTagDivGrid(
            [
                [
                    [ 
                        $oTagPagination, $aData['pagination']
                    ],
                    'TEST'
                ],
                [
                    [
                        $oTagTable, $aData['rows'], $aHeaders, $aAttrs
                    ]
                ]
            ],
            [ "class" => "table-crud" ],
            [ "class" => "row" ],
            [ "class" => "col" ]
        );

        // static::fnPrint();
    }
}