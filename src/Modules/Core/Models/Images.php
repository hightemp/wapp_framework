<?php

require_once("BaseModel.php");

define('T_IMAGES', 'timages');

class Images extends BaseModel
{
    static $sTableName = T_IMAGES;
    static $sNotesTableName = T_IMAGES_COLLECTIONS;

    static $sFilesGlobalPath = P_FIP;
    static $sFilesURLPath = P_BIP;
    static $sFilesRelPath = P_IP;
    static $sFILES_Key = 'file';

    static $sImagesLinkColumn = T_IMAGES."_id";

    static $sEmptyValue = '';

    static function fnExtractFileExtension($sFilePath)
    {
        preg_match("/(\w+)$/", $sFilePath, $aM);
        return $aM ? $aM[1] : '';
    }

    static function fnIsImageFile($sFilePath)
    {
        return static::fnIsImageExt(static::fnExtractFileExtension($sFilePath));
    }

    static function fnIsImageExt($sExt)
    {
        return in_array($sExt, ["jpg", "jpeg", "png", "gif", "webm"]);
    }

    static function fnGenerateUniqueFilename($sGlobalPath, $sExt='')
    {
        $sHash = md5_file($sGlobalPath);
        if (!$sExt) {
            $sExt = static::fnExtractFileExtension($sGlobalPath);
        }
        $sFileName = $sHash.".".$sExt;
        return $sFileName;
    }

    static function fnDetectAndCreate($aFILES, $aParams=[])
    {
        $aFILE = $aFILES[static::$sFILES_Key];
        $sExt = static::fnExtractFileExtension($aFILE['type']);
        $sFileName = static::fnGenerateUniqueFilename($aFILE['tmp_name'], $sExt);

        $sClass = static::fnIsImageExt($sExt) ? "Images" : "Files";

        $oItem = $sClass::fnFindOneByName($sFileName);

        if (!$oItem) {
            $oItem = $sClass::fnCreateOneFromFILES($aFILES, $aParams);
        }

        static::fnAddFoldersToItem($oItem);

        return $oItem;
    }

    static function fnGetGlobalPath($sFileName)
    {
        return static::$sFilesGlobalPath."/".$sFileName;
    }

    static function fnGetRelativePath($sFileName)
    {
        return static::$sFilesRelPath."/".$sFileName;
    }

    static function fnGetURLPath($sFileName)
    {
        return static::$sFilesURLPath."/".$sFileName;
    }

    static function fnAddFoldersToItem($oItem) 
    {
        $oItem->globalpath = static::fnGetGlobalPath($oItem->filename);
        $oItem->relpath = static::fnGetRelativePath($oItem->filename);
        $oItem->urlpath = static::fnGetURLPath($oItem->filename);
    }

    static function fnCreateOneFromFILES($aFILES=[], $aParams=[])
    {
        return static::fnCreate([
            ...$aFILES[static::$sFILES_Key],
            ...$aParams,
        ]);
    }

    static function fnCreateAllFromFILES($aFILES=[], $aParams=[])
    {
        $aResult = [];

        foreach ($aFILES as $sK => $aFILE) {
            $aP = isset($aParams[$sK]) ? $aParams[$sK] : [];
            $aResult[$sK] = static::fnCreate([
                ...$aFILE,
                ...$aP,
            ]);
        }

        return $aResult;
    }

    static function fnLinkItem($iID, $iParentID)
    {
        $oItem = static::findOne("id = ?", [$iID]);
        $oParentItem = static::findOne("id = ?", [$iParentID]);
        $oItem->{static::$sTableName} = $oParentItem;
        R::store($oItem);
    }

    static function fnCreate($aParams=[])
    {
        $oItem = static::dispense();

        $oItem->created_at = static::fnGetCurrentDateTime();
        $oItem->updated_at = static::fnGetCurrentDateTime();
        $oItem->timestamp = static::fnGetCurrentTimestamp();

        $oItem->description = isset($aParams['description']) ?: "";


        $oItem->name = $aParams['name'];
        $oItem->type = $aParams['type'];

        $sExt = static::fnExtractFileExtension($aParams['type']);

        if (isset($aParams['filename'])) {
            $oItem->filename = $aParams['filename'];
        } else {
            $sFileName = static::fnGenerateUniqueFilename($aParams['tmp_name'], $sExt);
            $oItem->filename = $sFileName;
        }
    
        $oItem->content = isset($aParams['content']) && $aParams['content'] ? $aParams['content'] : static::$sEmptyValue;
    
        if (isset($aParams['images_collections_id']) && !empty($aParams['images_collections_id'])) {
            $oItem->timagescollections = static::findOneCategory("id = ?", [$aParams['images_collections_id']]);
        }

    
        R::store($oItem);
    
        if ($aParams['tags_list']) {
            static::fnSetTags($oItem->id, explode(",", $aParams['tags_list']));
        }

        return $oItem;
    }

    static function fnUpdate($aParams=[])
    {
        $oItem = static::findOne("id = ?", [$aParams['id']]);

        $oItem->updated_at = static::fnGetCurrentDateTime();

        if (isset($aParams['name'])) $oItem->name = isset($aParams['name']) ?: "";
        if (isset($aParams['description'])) $oItem->description = isset($aParams['description']) ?: "";
        if (isset($aParams['content'])) $oItem->content = isset($aParams['content']) ?: static::$sEmptyValue;
    
        if (isset($aParams['images_collections_id']) && !empty($aParams['images_collections_id'])) {
            $oItem->timagescollections = static::findOneCategory("id = ?", [$aParams['images_collections_id']]);
        }
    
        if ($aParams['tags_list']) {
            static::fnSetTags($aParams['id'], explode(",", $aParams['tags_list']));
        }
    
        R::store($oItem);

        return $oItem;
    }

    static function fnDelete($aIDs)
    {
        foreach ($aIDs as $iID) {
            $oItem = static::findOneByID($iID);
        }
        static::fnDeleteByIDs($aIDs);
    }

    static function fnDeleteRecursive($aIDs)
    {
        static::fnDeleteRecursiveByIDs($aIDs);
    }

    static function fnPrepareItemItem($oItem)
    {
        return [
            'id' => $oItem->id,
            'text' => $oItem->name,
            'name' => $oItem->name,
            'description' => $oItem->description,
            'created_at' => $oItem->created_at,
            'images_collections_id' => $oItem->timagescollections ? $oItem->timagescollections->id : 0,
            'images_collection' => $oItem->timagescollections ? $oItem->timagescollections->name : "",
            'tags' => static::fnGetTagsAsStringList($oItem->id)
        ];
    }

    static function fnList($aParams=[])
    {
        $aImages = static::findAll("ORDER BY name ASC, id DESC");
        $aResult = [];
    
        foreach ($aImages as $oItem) {
            $aResult[] = static::fnPrepareItemItem($oItem);
        }

        return $aResult;
    }

    static function fnListForCollection($aParams=[])
    {
        if ($aParams['images_collections_id']<1) {
            $aImages = static::findAll("ORDER BY id DESC", []);
        } else {
            $aImages = static::findAll("timagescollections_id = ? ORDER BY name ASC, id DESC", [$aParams['images_collections_id']]);
        }
        $aResult = [];
    
        foreach ($aImages as $oItem) {
            $aResult[] = static::fnPrepareItemItem($oItem);
        }

        return $aResult;
    }

    static function fnGetOne($aParams=[], $bAddAdditionalFields=true)
    {
        $oItem = static::findOne("id = ?", [$aParams['id']]);

        $oItem = (object) $oItem->export();

        if (!$oItem->content) {
            $oItem->content = static::$sEmptyValue;
        }

        if ($bAddAdditionalFields) {
            $oItem->images_collection = $oItem->timagescollections->name;
            $oItem->images_collections_id = $oItem->timagescollections_id;
            // NOTE: Для tagcombobox возвращяем null
            $oItem->tags = static::fnGetTagsAsStringList(isset($aParams['id'])) ?: null;
        }

        return $oItem;
    }
}