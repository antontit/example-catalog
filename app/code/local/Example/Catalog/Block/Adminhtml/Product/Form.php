<?php

class Example_Catalog_Block_Adminhtml_Product_Form
    extends Mage_Adminhtml_Block_Catalog_Form
{
    protected function _prepareForm()
    {
        $product = $this->getProduct();

        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('general', array('legend' => Mage::helper('catalog')->__('General')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('catalog')->__('Name'),
            'title' => Mage::helper('catalog')->__('Name'),
            'name' => 'name',
            'value' => $product->getName(),
            'required' => true
        ));

        $fieldset->addField('price', 'text', array(
            'name' => 'price',
            'label' => Mage::helper('catalog')->__('Price'),
            'title' => Mage::helper('catalog')->__('Price'),
            'required' => true,
            'value' => (float) $product->getPrice(),
            'class' => 'validate-zero-or-greater'
        ));

        $fieldset->addField('qty', 'text', array(
            'name' => 'qty',
            'label' => Mage::helper('catalog')->__('Qty'),
            'title' => Mage::helper('catalog')->__('Qty'),
            'required' => true,
            'value' => (float) $product->getStockItem()->getQty(),
            'class' => 'validate-zero-or-greater'
        ));

        $this->setForm($form);
    }

    /**
     * @return Mage_Catalog_Model_Product
     */
    public function getProduct()
    {
        return Mage::registry('current_product');
    }
}
