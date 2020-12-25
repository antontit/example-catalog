<?php

class Example_Catalog_Model_EventLog extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('example_catalog/EventLog');
    }

    /**
     * @param string $eventName
     * @param array $data
     * @throws Exception
     */
    public function saveEvent($eventName, $data)
    {
        $insertData = array(
            'event' => $eventName,
            'data' => json_encode($data),
            'created' => Mage::getModel('core/date')->gmtDate()
        );
        
        $this->setData($insertData)->save();
    }
}
