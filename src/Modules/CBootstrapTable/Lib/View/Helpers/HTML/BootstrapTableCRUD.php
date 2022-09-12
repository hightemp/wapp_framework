<?php

namespace Hightemp\WappFramework\Modules\CBootstrapTable\Lib\Tags\HTML;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;
use Hightemp\WappFramework\Modules\Core\Lib\Tags\TagTable;
use Hightemp\WappFramework\Modules\Core\Lib\Tags\TagDivGrid;
use Hightemp\WappFramework\Modules\CBootstrapTable\Lib\Tags\TagPagination;
use Hightemp\WappFramework\Modules\CBootstrapTable\Lib\Tags\TagBootstrapTable;
use Hightemp\WappFramework\Modules\CBootstrapTable\Lib\View\Helpers\HTML;

class BootstrapTableCRUD extends BaseHTMLHelper
{
    public function __invoke($aEntity)
    {
        $aData = $aEntity["aData"];
        $aHeaders = $aEntity["aHeaders"];
        $aAttrs = $aEntity["aAttrs"];
        $aURLs = $aEntity["aURLs"];

        $sPagination = $aEntity["sPagination"];
        $sTable = $aEntity["sTable"];
        $sPanelButtons = $aEntity["sPanelButtons"];

        $aAttrs["class"] = "table table-striped table-bordered";

        HTML::TagDivGrid(
            [
                [
                    '',
                    [ 
                        $sPagination,
                        '',
                    ],
                    $sPanelButtons
                ],
                [
                    [
                        $sTable
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