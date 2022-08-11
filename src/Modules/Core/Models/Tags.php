<?php

require_once("BaseModel.php");

define('T_TAGS', 'ttags');
define('T_TAGS_TO_OBJECTS', 'ttagstoobjectss');

class TagsToObjects extends BaseModel 
{
    static $sTableName = T_TAGS_TO_OBJECTS;

    static function fnCreate($aParams=[])
    {
        $oRelation = TagsToObjects::findOrCreate([
            'ttags_id' => $aParams['ttags_id'],
            'content_id' => $aParams['content_id'],
            'content_type' => $aParams['content_type'],
        ]);

        return $oRelation;
    }

    static function fnGetTags($iContentID, $sContentType) 
    {
        return static::findAll('content_id = ? AND content_type = ?', [$iContentID, $sContentType]);
    }

    static function fnDeleteTags($iContentID, $sContentType)
    {
        R::exec("DELETE ".static::$sTableName." WHERE content_id='?' AND content_type='?'", [$iContentID, $sContentType]);
    }
}

class Tags extends BaseModel 
{
    static $sTableName = T_TAGS;

    static function fnCreate($aParams=[])
    {
        $oTag = static::findOrCreate([
            'name' => $aParams['name'], 
        ]);

        return $oTag;
    }

    static function fnGetTagsIDs($iContentID, $sContentType) 
    {
        return array_map(function($oI) { return $oI->id; }, TagsToObjects::fnGetTags($iContentID, $sContentType));
    }

    static function fnGetTags($iContentID, $sContentType) 
    {
        return array_map(function($oI) { return $oI->ttags->name; }, TagsToObjects::fnGetTags($iContentID, $sContentType));
    }

    static function fnGetTagsAsStringListFor($iContentID, $sContentType) 
    {
        return join(",", static::fnGetTags($iContentID, $sContentType));
    }

    static function fnSetTagsFor($iContentID, $sContentType, $aTags) 
    {
        $aTagsIDs = [];
        foreach ($aTags as $sTag) {
            if (!trim($sTag)) continue;

            $oTag = static::findOrCreate([
                'name' => $sTag, 
            ]);

            // R::store($oTag);

            $aTagsIDs[] = $oTag->id;
        }

        static::fnSetTagsByIDs($iContentID, $sContentType, $aTagsIDs);
    }

    static function fnSetTagsByIDs($iContentID, $sContentType, $aTags) 
    {
        TagsToObjects::fnDeleteTags($iContentID, $sContentType);
        foreach ($aTags as $iTagID) {
            $oRelation = TagsToObjects::findOrCreate([
                'ttags_id' => $iTagID,
                'content_id' => $iContentID,
                'content_type' => $sContentType,
            ]);

            // R::store($oRelation);
        }
    }
}