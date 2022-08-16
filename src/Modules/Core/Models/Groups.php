<?php

require_once("BaseModel.php");

define('T_GROUPS', 'tgroups');

class Groups extends BaseModel
{
    static $sTableName = T_GROUPS;

    static function fnCreate($aParams=[])
    {
        $oGroup = static::dispense();

        $oGroup->created_at = static::fnGetCurrentDateTime();
        $oGroup->updated_at = static::fnGetCurrentDateTime();
        $oGroup->timestamp = static::fnGetCurrentTimestamp();
        $oGroup->name = isset($aParams['name']) ?: "";
        $oGroup->description = isset($aParams['description']) ?: "";
    
        if (isset($aParams['content'])) {
            if (isset($aParams['option_upload_images'])) {
                fnUploadFromContent($aParams['content']);
            }
            $oGroup->content = isset($aParams['content']) ?: "";
        }
    
        if (isset($aParams['category_id']) && !empty($aParams['category_id'])) {
            $oGroup->tcategories = static::findOneCategory("id = ?", [$aParams['category_id']]);
        }
    
        R::store($oGroup);
    
        if ($aParams['tags_list']) {
            static::fnSetTags($oGroup->id, explode(",", $aParams['tags_list']));
        }

        // GroupsHistory::fnCreateCreateEvent($oGroup);

        return $oGroup;
    }

    static function fnUpdate($aParams=[])
    {
        $oGroup = static::findOne("id = ?", [$aParams['id']]);

        $oGroup->updated_at = static::fnGetCurrentDateTime();

        if (isset($aParams['name'])) $oGroup->name = isset($aParams['name']) ?: "";
        if (isset($aParams['description'])) $oGroup->description = isset($aParams['description']) ?: "";
        if (isset($aParams['content'])) $oGroup->content = isset($aParams['content']) ?: "";
    
        if (isset($aParams['category_id']) && !empty($aParams['category_id'])) {
            $oGroup->tcategories = static::findOneCategory("id = ?", [$aParams['category_id']]);
        }
    
        if ($aParams['tags_list']) {
            static::fnSetTags($aParams['id'], explode(",", $aParams['tags_list']));
        }
    
        R::store($oGroup);

        // GroupsHistory::fnCreateUpdateEvent($oGroup);

        return $oGroup;
    }

    static function fnDelete($aIDs)
    {
        R::trashBatch(static::$sTableName, $aIDs);

        foreach ($aIDs as $iID) {
            $oGroup = static::fnGetOne(["id" => $iID]);
            // GroupsHistory::fnCreateDeleteEvent($oGroup);
        }
    }

    static function fnPrepareNoteItem($oGroup)
    {
        return [
            'id' => $oGroup->id,
            'text' => $oGroup->name,
            'name' => $oGroup->name,
            'description' => $oGroup->description,
            'created_at' => $oGroup->created_at,
            'category_id' => $oGroup->tcategories ? $oGroup->tcategories->id : 0,
            'category' => $oGroup->tcategories ? $oGroup->tcategories->name : "",
            'tags' => static::fnGetTagsAsStringList($oGroup->id)
        ];
    }

    static function fnList($aParams=[])
    {
        $aGroups = static::findAll("ORDER BY name ASC, id DESC");
        $aResult = [];
    
        foreach ($aGroups as $oGroup) {
            $aResult[] = static::fnPrepareNoteItem($oGroup);
        }

        return $aResult;
    }

    static function fnListForCategory($aParams=[])
    {
        if ($aParams['category_id']<1) {
            $aGroups = static::findAll("ORDER BY id DESC", []);
        } else {
            $aGroups = static::findAll("tcategories_id = ? ORDER BY name ASC, id DESC", [$aParams['category_id']]);
        }
        $aResult = [];
    
        foreach ($aGroups as $oGroup) {
            $aResult[] = static::fnPrepareNoteItem($oGroup);
        }

        return $aResult;
    }

    static function fnGetOne($aParams=[], $bAddAdditionalFields=true)
    {
        $oGroup = static::findOne("id = ?", [$aParams['id']]);

        // GroupsHistory::fnCreateOpenEvent($oGroup);

        $oGroup = (object) $oGroup->export();
        if ($bAddAdditionalFields) {
            $oGroup->category = $oGroup->tcategories->name;
            $oGroup->category_id = $oGroup->tcategories_id;
            // NOTE: Для tagcombobox возвращяем null
            $oGroup->tags = static::fnGetTagsAsStringList(isset($aParams['id'])) ?: null;
        }

        return $oGroup;
    }
}