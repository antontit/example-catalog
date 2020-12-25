<?php

abstract class Example_Catalog_Observer_Log extends Example_Catalog_Observer_Abstract
{
    //########################################

    /**
     * @param array $data
     * @throws Exception
     */
    protected function saveToLog($data)
    {
        $model = $this->getEventLogModel();
        $model->saveEvent($this->getEvent()->getName(), $data);
    }

    /**
     * @return Example_Catalog_Model_EventLog
     */
    protected function getEventLogModel()
    {
        return Mage::getModel('example_catalog/EventLog');
    }

    //########################################
}
