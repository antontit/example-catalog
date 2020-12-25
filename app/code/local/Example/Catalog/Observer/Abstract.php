<?php

abstract class Example_Catalog_Observer_Abstract
{
    /**
     * @var null|Varien_Event_Observer
     */
    protected $_eventObserver = null;

    //########################################

    abstract public function process();

    //########################################

    /**
     * @param Varien_Event_Observer $eventObserver
     */
    public function setEventObserver(Varien_Event_Observer $eventObserver)
    {
        $this->_eventObserver = $eventObserver;
    }

    /**
     * @return Varien_Event_Observer
     * @throws \LogicException
     */
    protected function getEventObserver()
    {
        if (!($this->_eventObserver instanceof Varien_Event_Observer)) {
            throw new \LogicException('Property "eventObserver" should be set first.');
        }

        return $this->_eventObserver;
    }

    //########################################

    /**
     * @return Varien_Event
     */
    protected function getEvent()
    {
        return $this->getEventObserver()->getEvent();
    }

    //########################################
}
