<?php

use Civi\Api4\Asset;
use Civi\Api4\Contact;
use Civi\Api4\Generic\Result;
use Civi\Api4\OptionValue;

class CRM_Assetlist_BAO_Asset extends CRM_Assetlist_DAO_Asset {
  /**
   * Retrieve the available system asset types.
   *
   * @return Result
   * @throws API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public static function getAssetTypes(): Result {
    return OptionValue::get(FALSE)
      ->addSelect('value', 'label')
      ->addWhere('option_group_id:name', '=', CRM_Assetlist_Managed::ASSET_TYPE_OPTGROUP_NAME)
      ->execute();
  }

  /**
   * @param int $contactId
   * @return int
   * @throws API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public static function getContactAssetPossessionCount(int $contactId): int {
    $assets = Asset::get()
      ->addSelect('id')
      ->addWhere('asset_possessor_contact_id', '=', $contactId)
      ->execute();

    return count($assets);
  }

  /**
   * @param int $contactId
   * @return int
   * @throws API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public static function getContactAssetOwnerCount(int $contactId): int {
    $assets = Asset::get()
      ->addSelect('id')
      ->addWhere('asset_owner_contact_id', '=', $contactId)
      ->execute();

    return count($assets);
  }

  /**
   * @return Result
   * @throws API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public static function all(): Result {
    $assets = Asset::get()->execute();

    // TODO: This is pretty gross, refactor
    foreach ($assets as &$asset) {
      $asset['asset_type_id'] = OptionValue::get()
        ->addSelect('label')
        ->addWhere('option_group_id:name', '=', CRM_Assetlist_Managed::ASSET_TYPE_OPTGROUP_NAME)
        ->addWhere('value', '=', $asset['asset_type_id'])
        ->execute()
        ->first()['label'];

      $asset['asset_owner_contact_id'] = Contact::get()
        ->addSelect('display_name')
        ->addWhere('id', '=', $asset['asset_owner_contact_id'])
        ->execute()
        ->first();

      $asset['asset_possessor_contact_id'] = Contact::get()
        ->addSelect('display_name')
        ->addWhere('id', '=', $asset['asset_possessor_contact_id'])
        ->execute()
        ->first();
    }
    // Passing $asset as reference in foreach leaves hanging reference, unset it.
    unset($asset);

    return $assets;
  }
}
