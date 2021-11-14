<?php

use CRM_Assetlist_ExtensionUtil as E;
use Civi\Api4\Asset;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Assetlist_Form_CreateAssetForm extends CRM_Core_Form {
  public function buildQuickForm() {
    CRM_Utils_System::setTitle(ts('Create New Asset'));

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
    $this->add('select','asset_type',ts('Asset Type'), $assetTypes,TRUE);
    $this->add('textarea', 'description', ts('Description'), NULL, TRUE);
    $this->addEntityRef('owner_contact_id', ts('Owner'), ['create' => FALSE], TRUE);
    // TODO: Maybe set required to true here?
    $this->addEntityRef('possessor_contact_id', ts('Possessor'), ['create' => FALSE], FALSE);

    $this->addButtons([
      [
        'type' => 'submit',
        'name' => E::ts('Submit'),
        'isDefault' => TRUE,
      ]
    ]);

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  /**
   * Post Process function.
   *
   * Creates the asset and redirects to confirmation page.
   */
  public function postProcess() {
    $vals = $this->controller->exportValues($this->_name);

    try {
      Asset::create()
        ->addValue('name', $vals['asset_name'])
        ->addValue('asset_type_id', $vals['asset_type'])
        ->addValue('asset_description', $vals['description'])
        ->addValue('asset_owner_contact_id', $vals['owner_contact_id'])
        ->addValue('asset_possessor_contact_id', $vals['possessor_contact_id'])
        ->execute();
    }
    catch (API_Exception $e) {
      Civi::log(E::LONG_NAME)->notice('Error creating asset', [
        'code' => $e->getCode(),
        'error' => $e->getMessage()
      ]);

      CRM_Core_Error::statusBounce(E::ts('Failed to create asset.'));
    }

    CRM_Core_Session::setStatus(E::ts('Successfully created asset.'), E::ts('Success!'), 'success');
  }

  /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  public function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = array();
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
