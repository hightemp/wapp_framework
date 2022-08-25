<?php

namespace Hightemp\WappTestSnotes\Modules\CBootstrapTable\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Tags\TagTable;
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

        $oTag = new TagTable();

        // TODO: panel

        $oTag($aData['rows'], $aHeaders, $aAttrs);

        // TODO: pagination
    }
}