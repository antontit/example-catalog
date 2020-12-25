<?php

class Example_Catalog_Observer_Dispatcher
{
    //########################################

    public function massIncreased(Varien_Event_Observer $eventObserver)
    {
        $this->process('Catalog_MassAction_Increased', $eventObserver);
    }

    public function massDecreased(Varien_Event_Observer $eventObserver)
    {
        $this->process('Catalog_MassAction_Decreased', $eventObserver);
    }

    //########################################

    public function productSaved(Varien_Event_Observer $eventObserver)
    {
        $this->process('Product_Saved', $eventObserver);
    }

    //########################################

    private function process($observerModel, Varien_Event_Observer $eventObserver)
    {
        try {

            /** @var Example_Catalog_Observer_Abstract $observer */
            $observer = Mage::getModel('example_catalog_observer/' . $observerModel);
            $observer->setEventObserver($eventObserver);
            $observer->process();

        } catch (Exception $e) {
            Mage::logException($e);
        }
    }

    //########################################
}