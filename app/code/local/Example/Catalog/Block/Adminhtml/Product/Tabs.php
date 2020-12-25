<?php

class Example_Catalog_Block_Adminhtml_Product_Tabs
    extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId(strtolower(__CLASS__));
        $this->setDestElementId('product_edit_form');
        $this->setTitle(Mage::helper('catalog')->__('Product Information'));
    }

    protected function _prepareLayout()
    {
        $this->addTab('General', array(
            'label'     => Mage::helper('catalog')->__('General'),
            'content'   => $this->getLayout()->createBlock('example_catalog/adminhtml_product_form')->toHtml(),
            'active'    => true
        ));

        return parent::_prepareLayout();
    }
}
