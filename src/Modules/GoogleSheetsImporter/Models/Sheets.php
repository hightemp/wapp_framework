<?php

namespace Hightemp\WappTestSnotes\Modules\GoogleSheetsImporter\Models;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Columns\VarcharColumn;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Models\CRUDModel;

class Sheets extends CRUDModel
{
    public const TABLE_NAME="sheets";

    public const C_DOCUMENT_NAME = "document_name";
    public const C_DOCUMENT_ID = "document_id";

    public const COLUMNS = [
        self::C_INDEX_ID => IndexID::class,
        self::C_DOCUMENT_NAME => VarcharColumn::class,
        self::C_DOCUMENT_ID => VarcharColumn::class,
    ];
}