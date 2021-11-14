<?php

class CRM_Assetlist_Managed {
  public const ASSET_TYPE_OPTGROUP_NAME = 'asset_types';

  public static function set(&$entities) {
    $entities[] = [
      'module' => 'assetlist',
      'name' => self::ASSET_TYPE_OPTGROUP_NAME,
      'entity' => 'OptionGroup',
      'params' => [
        'version' => '3',
        'name' => self::ASSET_TYPE_OPTGROUP_NAME,
        'title' => ts('Asset Types'),
        'description' => ts('Types of asset that the Organization provides.'),
        'is_reserved' => 1,
        'is_active' => 1,
        'data_type' => 'String',
        'is_locked' => 0
      ],
    ];
  }
}
