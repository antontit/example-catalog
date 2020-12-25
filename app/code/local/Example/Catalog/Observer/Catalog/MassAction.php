<?php

class Example_Catalog_Observer_Catalog_MassAction extends Example_Catalog_Observer_Log
{
    public function process()
    {
        $event = $this->getEvent();

        $this->saveToLog(array(
            'product_ids' => $event->getData('productIds'),
            'percent'     => $event->getData('percent'),
            'store_id'    => $event->getData('storeId')
        ));
    }
}