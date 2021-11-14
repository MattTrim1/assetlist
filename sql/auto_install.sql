-- +--------------------------------------------------------------------+
-- | Copyright CiviCRM LLC. All rights reserved.                        |
-- |                                                                    |
-- | This work is published under the GNU AGPLv3 license with some      |
-- | permitted exceptions and without any warranty. For full license    |
-- | and copyright information, see https://civicrm.org/licensing       |
-- +--------------------------------------------------------------------+
--
-- Generated from schema.tpl
-- DO NOT EDIT.  Generated by CRM_Core_CodeGen
--
-- /*******************************************************
-- *
-- * Clean up the existing tables - this section generated from drop.tpl
-- *
-- *******************************************************/

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `civicrm_asset`;

SET FOREIGN_KEY_CHECKS=1;
-- /*******************************************************
-- *
-- * Create new tables
-- *
-- *******************************************************/

-- /*******************************************************
-- *
-- * civicrm_asset
-- *
-- * Stores data for physical assets.
-- *
-- *******************************************************/
CREATE TABLE `civicrm_asset` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique Asset ID',
  `name` varchar(255) NOT NULL COMMENT 'Asset Name',
  `asset_type_id` int unsigned NOT NULL COMMENT 'Virtual FK to Asset Type ID.',
  `asset_description` varchar(850) COMMENT 'A text-based description of the asset.',
  `asset_owner_contact_id` int unsigned COMMENT 'FK to Contact that owns the asset (usually an organisation).',
  `asset_possessor_contact_id` int unsigned COMMENT 'FK to Contact that possesses the asset (usually an individual).',
  PRIMARY KEY (`id`),
  CONSTRAINT FK_civicrm_asset_asset_owner_contact_id FOREIGN KEY (`asset_owner_contact_id`) REFERENCES `civicrm_contact`(`id`) ON DELETE NO ACTION,
  CONSTRAINT FK_civicrm_asset_asset_possessor_contact_id FOREIGN KEY (`asset_possessor_contact_id`) REFERENCES `civicrm_contact`(`id`) ON DELETE NO ACTION
)
ENGINE=InnoDB;
