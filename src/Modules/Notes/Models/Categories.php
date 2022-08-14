<?php

require_once("BaseModel.php");

define('T_CATEGORIES', 'tcategories');

class Notes extends BaseModel
{
    static $sTableName = T_CATEGORIES;
    static $sNotesTableName = T_CATEGORIES;
    static $sGroupsTableName = T_GROUPS;
    static $sImagesCollectionsTableName = T_IMAGES_COLLECTIONS;

    static $sParentKey = T_CATEGORIES."_id";

    static function fnCreate($aParams=[])
    {
        $oCategory = static::dispense();

        $oCategory->created_at = static::fnGetCurrentDateTime();
        $oCategory->updated_at = static::fnGetCurrentDateTime();
        $oCategory->timestamp = static::fnGetCurrentTimestamp();
        $oCategory->name = $aParams['name'] ?: "";
        $oCategory->description = $aParams['description'] ?: "";
    
        if (isset($aParams['category_id']) && !empty($aParams['category_id'])) {
            $oCategory->tcategories = static::findOneCategory("id = ?", [$aParams['category_id']]);
        }
    
        R::store($oCategory);
    
        if (isset($aParams['tags_list']) && !empty($aParams['tags_list'])) {
            static::fnSetTags($oCategory->id, explode(",", $aParams['tags_list']));
        }

        // NotesHistory::fnCreateCreateEvent($oCategory);

        return $oCategory;
    }

    static function fnUpdate($aParams=[])
    {
        $oCategory = static::findOne("id = ?", [$aParams['id']]);

        $oCategory->updated_at = static::fnGetCurrentDateTime();

        if (isset($aParams['name'])) $oCategory->name = $aParams['name'] ?: "";
        if (isset($aParams['description'])) $oCategory->description = $aParams['description'] ?: "";
    
        if (isset($aParams['category_id']) && !empty($aParams['category_id'])) {
            $oCategory->tcategories = static::findOneCategory("id = ?", [$aParams['category_id']]);
        }
    
        if (isset($aParams['tags_list']) && !empty($aParams['tags_list'])) {
            static::fnSetTags($aParams['id'], explode(",", $aParams['tags_list']));
        }
    
        R::store($oCategory);

        // NotesHistory::fnCreateUpdateEvent($oCategory);

        return $oCategory;
    }

    static function fnDelete($aIDs)
    {
        static::fnDeleteByIDs($aIDs);
    }

    static function fnDeleteRecursive($aIDs)
    {
        static::fnDeleteRecursiveByIDs($aIDs);
    }

    static function fnPrepareNoteItem($oCategory)
    {
        return [
            'id' => $oCategory->id,
            'text' => $oCategory->name,
            'name' => $oCategory->name,
            'description' => $oCategory->description,
            'created_at' => $oCategory->created_at,
            'category_id' => $oCategory->tcategories ? $oCategory->tcategories->id : 0,
            'category' => $oCategory->tcategories ? $oCategory->tcategories->name : "",
            'tags' => static::fnGetTagsAsStringList($oCategory->id)
        ];
    }

    static function fnBuildRecursiveNotesTree(&$aResult, $aNotes) 
    {
        $aResult = [];

        foreach ($aNotes as $oCategory) {
            $aTreeChildren = [];

            $aChildren = R::children($oCategory, " tcategories_id = {$oCategory->id} ORDER BY name ASC, id DESC");
            static::fnBuildRecursiveNotesTree($aTreeChildren, $aChildren);

            $aResult[] = [
                'id' => $oCategory->id,
                'text' => $oCategory->name,
                'name' => $oCategory->name,
                'description' => $oCategory->description,
                'category_id' => $oCategory->tcategories_id,
                'children' => $aTreeChildren,
                'count' => $oCategory->countOwn(T_IMAGES_COLLECTIONS)
            ];
        }
    }

    static function fnList($aParams=[])
    {
        $aNotes = static::findAll("tcategories_id IS NULL ORDER BY name ASC, id DESC");
        $aResult = [];

        static::fnBuildRecursiveNotesTree($aResult, $aNotes);

        $aResult = [
            [
                'id' => 0,
                'text' => "Все",
                'name' => "Все",
                'description' => "",
                'category_id' => null,
                'children' => $aResult,
                // 'count' => null
            ]
        ];
    
        // foreach ($aNotes as $oCategory) {
        //     $aResult[] = static::fnPrepareNoteItem($oCategory);
        // }

        return $aResult;
    }

    static function fnListForCategory($aParams=[])
    {
        if ($aParams['category_id']<1) {
            $aNotes = static::findAll("ORDER BY id DESC", []);
        } else {
            $aNotes = static::findAll("tcategories_id = ? ORDER BY name ASC, id DESC", [$aParams['category_id']]);
        }
        $aResult = [];

        static::fnBuildRecursiveNotesTree($aResult, $aNotes);
    
        // foreach ($aNotes as $oCategory) {
        //     $aResult[] = static::fnPrepareNoteItem($oCategory);
        // }

        return $aResult;
    }

    static function fnGetOne($aParams=[], $bAddAdditionalFields=true)
    {
        $oCategory = static::findOne("id = ?", [$aParams['id']]);

        // NotesHistory::fnCreateOpenEvent($oCategory);

        $oCategory = (object) $oCategory->export();
        if ($bAddAdditionalFields) {
            $oCategory->category = $oCategory->tcategories->name;
            $oCategory->category_id = $oCategory->tcategories_id;
            // NOTE: Для tagcombobox возвращяем null
            $oCategory->tags = static::fnGetTagsAsStringList($aParams['id']) ?: null;
        }

        return $oCategory;
    }
}