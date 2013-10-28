<?php
/**
 * Description of
 * @package   CueBlocks_
 * @company   CueBlocks - http://www.cueblocks.com/
 * @author    Francesco Magazzu' <francesco.magazzu at cueblocks.com>
 * @support   <magento at cueblocks.com>
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("
      DROP TABLE IF EXISTS {$this->getTable('popUp/popUp')};
        CREATE TABLE IF NOT EXISTS {$this->getTable('popUp/popUp')} (
            `id` int(11) unsigned NOT NULL auto_increment,
            `title` varchar(255) NOT NULL,
            `content` MEDIUMTEXT DEFAULT NULL,
            `date_from` varchar(255) NOT NULL,
            `date_to` varchar(255) NOT NULL,
            `is_active` int(1) NOT NULL,
            `store_ids` varchar(255) NOT NULL DEFAULT 0,
            `counter` int(255) NOT NULL DEFAULT 0,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");


$installer->endSetup();