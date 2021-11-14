<div class="crm-content-block crm-basic-criteria-form-block">
  <div class="crm-accordion-wrapper">
    <h2>{$count} {if $count eq 1}Asset{else}Assets{/if}</h2>
    <table class="crm-results-block">
      <tr>
        <th>{ts}Name{/ts}</th>
        <th>{ts}Type{/ts}</th>
        <th>{ts}Description{/ts}</th>
        <th>{ts}Possessor{/ts}</th>
        <th>{ts}Owner{/ts}</th>
        <th>{ts}Actions{/ts}</th>
      </tr>
        {foreach from=$assets key=k item=v}
          <tr>
            <td><a href="/civicrm/assets/view?reset=1&aid={$v.id}">{$v.name}</a></td>
            <td>{$v.asset_type_id}</td>
            <td>{$v.asset_description}</td>
            <td><a href="/civicrm/contact/view?reset=1&cid={$v.asset_possessor_contact_id.id}">{$v.asset_possessor_contact_id.display_name}</a></td>
            <td><a href="/civicrm/contact/view?reset=1&cid={$v.asset_owner_contact_id.id}">{$v.asset_owner_contact_id.display_name}</a></td>
            <td><a href="/civicrm/assets/view?reset=1&aid={$v.id}&action=delete">Delete</a></td>
          </tr>
        {/foreach}
    </table>
  </div>
</div>
