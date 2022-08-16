<?php

require_once("BaseModel.php");
require_once("ImagesCollectionsHistory.php");

define('T_IMAGES_COLLECTIONS', 'timagescollections');

class ImagesCollections extends BaseModel
{
    static $sTableName = T_IMAGES_COLLECTIONS;
    static $sNotesTableName = T_CATEGORIES;

    static $sImagesCollectionsLinkColumn = T_IMAGES_COLLECTIONS."_id";

    const L_RU = "RU";
    const L_EN = "EN";

    static $sEmptyValue = '';

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
        $oItem->name = isset($aParams['name']) ?: "";
        $oItem->description = isset($aParams['description']) ?: "";
        $oItem->language = isset($aParams['language']) ?: static::L_RU;
    
        $oItem->content = isset($aParams['content']) && $aParams['content'] ? $aParams['content'] : static::$sEmptyValue;
    
        if (isset($aParams['category_id']) && !empty($aParams['category_id'])) {
            $oItem->tcategories = static::findOneCategory("id = ?", [$aParams['category_id']]);
        }
    
        R::store($oItem);
    
        if ($aParams['tags_list']) {
            static::fnSetTags($oItem->id, explode(",", $aParams['tags_list']));
        }

        ImagesCollectionsHistory::fnCreateCreateEvent($oItem);

        return $oItem;
    }

    static function fnUpdate($aParams=[])
    {
        $oItem = static::findOne("id = ?", [$aParams['id']]);

        $oItem->updated_at = static::fnGetCurrentDateTime();

        if (isset($aParams['name'])) $oItem->name = isset($aParams['name']) ?: "";
        if (isset($aParams['description'])) $oItem->description = isset($aParams['description']) ?: "";
        if (isset($aParams['content'])) $oItem->content = isset($aParams['content']) ?: static::$sEmptyValue;
    
        if (isset($aParams['category_id']) && !empty($aParams['category_id'])) {
            $oItem->tcategories = static::findOneCategory("id = ?", [$aParams['category_id']]);
        }
    
        if ($aParams['tags_list']) {
            static::fnSetTags($aParams['id'], explode(",", $aParams['tags_list']));
        }
    
        R::store($oItem);

        ImagesCollectionsHistory::fnCreateUpdateEvent($oItem);

        return $oItem;
    }

    static function fnDelete($aIDs)
    {
        foreach ($aIDs as $iID) {
            $oItem = static::findOneByID($iID);
            ImagesCollectionsHistory::fnCreateDeleteEvent($oItem);
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
            'category_id' => $oItem->tcategories ? $oItem->tcategories->id : 0,
            'category' => $oItem->tcategories ? $oItem->tcategories->name : "",
            'tags' => static::fnGetTagsAsStringList($oItem->id)
        ];
    }

    static function fnList($aParams=[])
    {
        $aImagesCollections = static::findAll("ORDER BY name ASC, id DESC");
        $aResult = [];
    
        foreach ($aImagesCollections as $oItem) {
            $aResult[] = static::fnPrepareItemItem($oItem);
        }

        return $aResult;
    }

    static function fnListForCategory($aParams=[])
    {
        if ($aParams['category_id']<1) {
            $aImagesCollections = static::findAll("ORDER BY id DESC", []);
        } else {
            $aImagesCollections = static::findAll("tcategories_id = ? ORDER BY name ASC, id DESC", [$aParams['category_id']]);
        }
        $aResult = [];
    
        foreach ($aImagesCollections as $oItem) {
            $aResult[] = static::fnPrepareItemItem($oItem);
        }

        return $aResult;
    }

    static function fnGetOne($aParams=[], $bAddAdditionalFields=true)
    {
        $oItem = static::findOne("id = ?", [$aParams['id']]);

        ImagesCollectionsHistory::fnCreateOpenEvent($oItem);

        $oItem = (object) $oItem->export();

        if (!$oItem->content) {
            $oItem->content = static::$sEmptyValue;
        }

        if ($bAddAdditionalFields) {
            $oItem->category = $oItem->tcategories->name;
            $oItem->category_id = $oItem->tcategories_id;
            // NOTE: Для tagcombobox возвращяем null
            $oItem->tags = static::fnGetTagsAsStringList(isset($aParams['id'])) ?: null;
        }

        return $oItem;
    }
}