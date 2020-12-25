<?php

class Example_Catalog_Observer_Product_Saved extends Example_Catalog_Observer_Log
{
    public function process()
    {
        $event = $this->getEvent();

        $this->saveToLog(array(
            'product_id'   => $event->getData('productId'),
            'product_name' => $event->getData('productName'),
            'price'        => $event->getData('price'),
            'qty'          => $event->getData('qty'),
            'store_id'     => $event->getData('storeId')
        ));
    }
}
