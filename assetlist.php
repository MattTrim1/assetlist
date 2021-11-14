<?php

require_once 'assetlist.civix.php';
// phpcs:disable
use Civi\Api4\OptionGroup;
// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function assetlist_civicrm_config(&$config) {
  _assetlist_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function assetlist_civicrm_xmlMenu(&$files) {
  _assetlist_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function assetlist_civicrm_install() {
  _assetlist_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function assetlist_civicrm_postInstall() {
  _assetlist_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function assetlist_civicrm_uninstall() {
  _assetlist_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function assetlist_civicrm_enable() {
  _assetlist_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function assetlist_civicrm_disable() {
  _assetlist_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function assetlist_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _assetlist_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function assetlist_civicrm_managed(&$entities) {
  CRM_Assetlist_Managed::set($entities);

  _assetlist_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function assetlist_civicrm_caseTypes(&$caseTypes) {
  _assetlist_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function assetlist_civicrm_angularModules(&$angularModules) {
  _assetlist_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function assetlist_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _assetlist_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function assetlist_civicrm_entityTypes(&$entityTypes) {
  _assetlist_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_themes().
 */
function assetlist_civicrm_themes(&$themes) {
  _assetlist_civix_civicrm_themes($themes);
}

/**
 * Implements hook_civicrm_tabset().
 */
function assetlist_civicrm_tabset($tabsetName, &$tabs, $context) {
  if ($tabsetName === 'civicrm/contact/view' && !empty($context['contact_id'])) {
    $cid = $context['contact_id'];
    $owns = CRM_Assetlist_BAO_Asset::getContactAssetOwnerCount($cid);
    $possesses = CRM_Assetlist_BAO_Asset::getContactAssetPossessionCount($cid);
    $count = $owns + $possesses;

    $tab = [
      'id' => 'assets',
      'title' => ts('Assets'),
      'count' => $count ?? 0,
      'icon' => 'crm-i fa-laptop',
      'weight' => 999,
      'url' => CRM_Utils_System::url( 'civicrm/assets', "cid={$cid}"),
    ];

    $tabs[] = $tab;
  }
}

/**
 * Implements hook_civicrm_navigationMenu().
 */
function assetlist_civicrm_navigationMenu(&$menu) {
  $optGroupId = OptionGroup::get()
    ->addSelect('id')
    ->addWhere('name', '=', CRM_Assetlist_Managed::ASSET_TYPE_OPTGROUP_NAME)
    ->setLimit(1)
    ->execute()
    ->first()['id'];

  _assetlist_civix_insert_navigation_menu($menu, '', [
    'label' => ts('Assets'),
    'name' => 'assets',
    'icon' => 'crm-i fa-laptop'
  ]);
  _assetlist_civix_insert_navigation_menu($menu, 'assets', [
    'label' => ts('View Assets'),
    'name' => 'view-assets',
    'url' => CRM_Utils_System::url('civicrm/assets', 'reset=1'),
  ]);
  _assetlist_civix_insert_navigation_menu($menu, 'assets', [
    'label' => ts('Create Asset'),
    'name' => 'create-asset',
    'url' => CRM_Utils_System::url('civicrm/assets/create', 'reset=1'),
  ]);
  _assetlist_civix_insert_navigation_menu($menu, 'assets', [
    'label' => ts('Asset Types'),
    'name' => 'asset-types',
    'url' => CRM_Utils_System::url('civicrm/admin/options', "reset=1&gid={$optGroupId}"),
  ]);
}
