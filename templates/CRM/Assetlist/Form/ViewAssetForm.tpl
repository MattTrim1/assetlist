{if $action eq 8}
{* Are you sure to delete form *}
<h3>{ts}Delete Entity{/ts}</h3>
<div class="crm-block crm-form-block">
  <div class="crm-section">{ts}Are you sure you wish to delete this asset?{/ts}</div>
</div>

<div class="crm-submit-buttons">
    {include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
{else}

{foreach from=$elementNames item=elementName}
  <div class="crm-section">
    <div class="label">{$form.$elementName.label}</div>
    <div class="content">{$form.$elementName.html}</div>
    <div class="clear"></div>
  </div>
{/foreach}

<div class="crm-submit-buttons">
    {include file="CRM/common/formButtons.tpl" location="bottom"}
</div>

<script>
  const assetId = document.getElementById('asset_id')?.innerText ?? {$asset|escape:javascript};

  {literal}
  async function getAsset(assetId) {
    return await CRM.api4('Asset', 'get', {
      where: [["id", "=", assetId]]
    });
  }

  (async () => {
    const asset = await getAsset(assetId);

    console.log(asset);

    CRM.$(function($) {
      $('#asset_id').val(asset[0].id).trigger('change');
      $('#asset_name').val(asset[0].name).trigger('change');
      $('#asset_type').val(asset[0].asset_type_id).trigger('change');
      $('#description').val(asset[0].asset_description).trigger('change');
      $('#owner_contact_id').val(asset[0].asset_owner_contact_id).trigger('change');
      $('#possessor_contact_id').val(asset[0].asset_possessor_contact_id).trigger('change');
    });
  })();
  {/literal}
</script>
{/if}
