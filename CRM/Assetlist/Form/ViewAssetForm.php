<?php

use CRM_Assetlist_ExtensionUtil as E;
use Civi\Api4\Asset;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 *
 * TODO: Refactor all of this based on https://docs.civicrm.org/dev/en/latest/step-by-step/create-entity/#7-add-a-form
 */
class CRM_Assetlist_Form_ViewAssetForm extends CRM_Core_Form {
  public function buildQuickForm() {
    $aid = CRM_Utils_Request::retrieve('aid', 'Integer') ?? $this->controller->exportValue($this->_name, 'asset_id');

    $asset = Asset::get()
      ->addSelect('id')
      ->addWhere('id', '=', $aid)
      ->execute()
      ->first()['id'];

    $this->assign('asset', $asset);
    $this->add('hidden', 'asset_id', $aid);

    if ($this->_action !== CRM_Core_Action::DELETE) {
      CRM_Utils_System::setTitle(ts('View Asset'));

      $assetTypesRaw = CRM_Assetlist_BAO_Asset::getAssetTypes()->getArrayCopy();
      $assetTypes = array_column($assetTypesRaw, 'label');

      // Civi doesn't want to let me define custom keys from the option group value, so I have to do this disgusting stuff
      foreach ($assetTypes as $key => $type) {
        if ($key === 0) {
          unset($assetTypes[$key]);
        }
        $assetTypes[$key + 1] = $type;
      }

      $this->add('text', 'asset_name', ts('Name'), NULL, TRUE);
      $this->add('select', 'asset_type', ts('Asset Type'), $assetTypes, TRUE);
      $this->add('textarea', 'description', ts('Description'), NULL, TRUE);
      $this->addEntityRef('owner_contact_id', ts('Owner'), ['create' => FALSE], TRUE);
      // TODO: Maybe set required to true here?
      $this->addEntityRef('possessor_contact_id', ts('Possessor'), ['create' => FALSE], FALSE);

      $this->addButtons([
        [
          'type' => 'submit',
          'name' => E::ts('Submit'),
          'isDefault' => TRUE,
        ],
      ]);

      $this->assign('elementNames', $this->getRenderableElementNames());
    }
    else {
      $this->addButtons([
        ['type' => 'submit', 'name' => E::ts('Delete'), 'isDefault' => TRUE],
        ['type' => 'cancel', 'name' => E::ts('Cancel')]
      ]);
    }

    parent::buildQuickForm();
  }

  /**
   * Post Process function.
   */
  public function postProcess() {
    $vals = $this->controller->exportValues($this->_name);
    $this->assign('asset', $vals['asset_id']);

    if ($this->_action == CRM_Core_Action::DELETE) {
      Asset::delete()
        ->addWhere('id', '=', $vals['asset_id'])
        ->execute();

      CRM_Core_Session::setStatus(E::ts('Removed Asset'), E::ts('Asset'), 'success');
      CRM_Utils_System::redirect('/civicrm/assets');
    }
    else {
      try {
        Asset::update()
          ->addWhere('id', '=', $vals['asset_id'])
          ->addValue('name', $vals['asset_name'])
          ->addValue('asset_type_id', $vals['asset_type'])
          ->addValue('asset_description', $vals['description'])
          ->addValue('asset_owner_contact_id', $vals['owner_contact_id'])
          ->addValue('asset_possessor_contact_id', $vals['possessor_contact_id'])
          ->execute();
      }
      catch (API_Exception $e) {
        Civi::log(E::LONG_NAME)->notice('Error updating asset', [
          'code' => $e->getCode(),
          'error' => $e->getMessage()
        ]);
        CRM_Core_Error::statusBounce(E::ts('Failed to update asset.'));
      }
      CRM_Core_Session::setStatus(E::ts('Successfully updated asset.'), E::ts('Success!'), 'success');
    }
  }

  /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  public function getRenderableElementNames() {
    $elementNames = [];
    foreach ($this->_elements as $element) {
      /** @var HTML_QuickForm_Element $element */
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }
}
