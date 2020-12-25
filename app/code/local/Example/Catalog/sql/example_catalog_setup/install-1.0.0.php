<?php

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$tableEventsLogs = $installer->getTable('example_catalog/EventLog');

$installer->startSetup();

$installer->getConnection()->dropTable($tableEventsLogs);

$table = $installer->getConnection()
    ->newTable($tableEventsLogs)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
    ))
    ->addColumn('event', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => true,
        'default' => null,
    ))
    ->addColumn('data', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => true,
        'default' => null,
    ))
    ->addColumn('created', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable'  => false,
    ));

$installer->getConnection()->createTable($table);