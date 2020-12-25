<?php

class Example_Catalog_Block_Adminhtml_Product_Edit
    extends Mage_Adminhtml_Block_Catalog_Product_Edit
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('example_catalog/product/edit.phtml');
        $this->setId(strtolower(__CLASS__));
    }

    protected function _prepareLayout()
    {
        $this->setChild('come_back_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('catalog')->__('Back'),
                    'onclick'   => 'setLocation(\''. $this->getUrl('*/adminhtml_catalog/index', array('_current'=>true)).'\')',
                    'class' => 'back'
                ))
        );

        $this->setChild('reset_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('catalog')->__('Reset'),
                    'onclick'   => 'setLocation(\''.$this->getUrl('*/*/*', array('_current'=>true)).'\')'
                ))
        );

        $this->setChild('save_and_edit_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('catalog')->__('Save and Continue Edit'),
                    'onclick'   => 'saveAndContinueEdit(\''.$this->getSaveAndContinueUrl().'\')',
                    'class' => 'save'
                ))
        );

        return parent::_prepareLayout();
    }

    public function getSaveAndContinueUrl()
    {
        return $this->getUrl('*/*/save', array('_current'   => true));
    }

    public function getHeader()
    {
        $product = $this->getProduct();
        $header = $this->escapeHtml($product->getName());
        $header .= ' (ID# ' . $product->getId() . ')';
        return $header;
    }

    public function getBackButtonHtml()
    {
        return $this->getChildHtml('come_back_button');
    }

    public function getCancelButtonHtml()
    {
        return $this->getChildHtml('reset_button');
    }

    public function getSaveAndEditButtonHtml()
    {
        return $this->getChildHtml('save_and_edit_button');
    }
}
