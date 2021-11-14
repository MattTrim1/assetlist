<?php

class CRM_Assetlist_Page_ViewAssetsPage extends CRM_Core_Page {
  public function run() {
    CRM_Utils_System::setTitle(ts('View Assets'));

    $assets = CRM_Assetlist_BAO_Asset::all();

    $cid = CRM_Utils_Request::retrieve('cid', 'Integer');
    if (!is_null($cid)) {
      $assets = array_filter($assets->getArrayCopy(), function ($asset) use ($cid) {
        return $cid === $asset['asset_possessor_contact_id']['id'] || $cid === $asset['asset_owner_contact_id']['id'];
      });
    }

    $this->assign('count', count($assets));
    $this->assign('assets', $assets);

    parent::run();
  }
}
