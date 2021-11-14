# AssetList
[![forthebadge](https://forthebadge.com/images/badges/built-with-love.svg)](https://forthebadge.com)

Does your CiviCRM instance store staff members and organisational volunteers? Do you provide them with assets, so they
can fulfil their responsibilities? This is the extension for you!

AssetList provides convenient functionality that allows an organisation to keep track of the assets they own and which
contact is in possession of that asset.

This extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements

* PHP v7.4+
* CiviCRM 5.43+

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/FIXME/assetlist.git
cv en assetlist
```

## Getting Started

### Adding a New Asset Type
1. Navigate to the 'Assets' menu
2. Press 'Asset Types'
3. Press the 'Add Asset Type' button

_PLEASE NOTE_ that the Value of the option value must remain as the default numeric value.

### Adding a New Asset
1. Navigate to the 'Assets' menu
2. Press 'Create Asset'
3. Fill in the form and submit

### Viewing Assets for an  individual contact
1. Navigate to the contact record
2. Press the 'Assets' tab

## Known Issues

1. Asset Value is not yet implemented
2. Audit Trail of an Asset is not yet implemented
3. Asset Search / Pagination is not yet implemented
