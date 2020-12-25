<?php

class Example_Catalog_Model_Resource_EventLog
    extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        $this->_init('example_catalog/EventLog', 'id');
    }
}
