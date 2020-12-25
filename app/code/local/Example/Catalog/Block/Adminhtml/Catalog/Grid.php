<?php

class Example_Catalog_Block_Adminhtml_Catalog_Grid
    extends Mage_Adminhtml_Block_Catalog_Product_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId(strtolower(__CLASS__));
    }

    protected function _preparePage()
    {
        parent::_preparePage();
        $this->getCollection()->addAttributeToFilter('type_id', array('eq' => 'simple'));
    }

    protected function _prepareColumns()
    {
        $store = $this->_getStore();

        $this->addColumn('entity_id', array(
            'header' => Mage::helper('review')->__('ID'),
            'width' => '50px',
            'type' => 'number',
            'index' => 'entity_id',
        ));

        $this->addColumn('name', array(
            'header' => Mage::helper('review')->__('Name'),
            'index' => 'name',
        ));

        $this->addColumn('sku', array(
            'header' => Mage::helper('review')->__('SKU'),
            'width' => '80px',
            'index' => 'sku'
        ));

        $this->addColumn('price', array(
            'header' => Mage::helper('catalog')->__('Price'),
            'type' => 'price',
            'currency_code' => $store->getBaseCurrency()->getCode(),
            'index' => 'price',
        ));

        $this->addColumn('qty', array(
            'header' => Mage::helper('catalog')->__('Qty'),
            'width' => '100px',
            'type' => 'number',
            'index' => 'qty',
        ));

        $this->addColumn('status', array(
            'header' => Mage::helper('catalog')->__('Status'),
            'width' => '70px',
            'index' => 'status',
            'type' => 'options',
            'options' => Mage::getSingleton('catalog/product_status')->getOptionArray(),
        ));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('product');

        $this->getMassactionBlock()->addItem('increase_price', array(
            'label' => Mage::helper('catalog')->__('Increase Price'),
            'url' => $this->getUrl('*/adminhtml_catalog/massIncrease'),
            'confirm' => Mage::helper('catalog')->__('Are you sure?')
        ));

        $this->getMassactionBlock()->addItem('decrease_price', array(
            'label' => Mage::helper('catalog')->__('Decrease Price'),
            'url' => $this->getUrl('*/adminhtml_catalog/massDecrease'),
            'confirm' => Mage::helper('catalog')->__('Are you sure?')
        ));

        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/adminhtml_product/edit', array(
                'store' => $this->getRequest()->getParam('store'),
                'product_id' => $row->getId())
        );
    }
}