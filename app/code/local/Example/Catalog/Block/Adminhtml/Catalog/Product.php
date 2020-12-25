<?php

class Example_Catalog_Block_Adminhtml_Catalog_Product
    extends Mage_Adminhtml_Block_Widget_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('catalog/product.phtml');
    }

    protected function _prepareLayout()
    {
        $this->setChild('grid', $this->getLayout()->createBlock('example_catalog/adminhtml_catalog_grid'));
        $this->setChild('store_switcher', $this->getLayout()->createBlock('adminhtml/store_switcher'));
        return parent::_prepareLayout();
    }

    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }

    public function isSingleStoreMode()
    {
        return Mage::app()->isSingleStoreMode();
    }
}
