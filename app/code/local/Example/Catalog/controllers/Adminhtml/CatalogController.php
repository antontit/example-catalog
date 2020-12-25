<?php

class Example_Catalog_Adminhtml_CatalogController
    extends Example_Catalog_Controller_Adminhtml_BaseController
{
    //########################################

    public function indexAction()
    {
        $this->loadLayout();
        $this->_activateMenu();
        $block = $this->getLayout()->createBlock('example_catalog/adminhtml_catalog_product');
        $this->_addContent($block);
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout();
        $block = $this->getLayout()->createBlock('example_catalog/adminhtml_catalog_grid');
        $this->getResponse()->setBody($block->toHtml());
    }

    //########################################

    public function massIncreaseAction()
    {
        $this->_handleMassAction(function (array $productIds, $storeId) {
            $percent = $this->_getDefaultPercent();
            $this->_getPriceModel()->massIncreasePrice($productIds, $percent, $storeId);
            Mage::dispatchEvent('example_catalog_mass_increased', compact('productIds', 'percent', 'storeId'));
        });
    }

    public function massDecreaseAction()
    {
        $this->_handleMassAction(function (array $productIds, $storeId) {
            $percent = $this->_getDefaultPercent();
            $this->_getPriceModel()->massDecreasePrice($productIds, $percent, $storeId);
            Mage::dispatchEvent('example_catalog_mass_decreased', compact('productIds', 'percent', 'storeId'));
        });
    }

    private function _handleMassAction(callable $handler)
    {
        $productIds = (array) $this->getRequest()->getParam('product');
        $storeId    = (int) $this->getRequest()->getParam('store', 0);

        if (!is_array($productIds)) {
            $this->_getSession()->addError($this->__('Please select product(s).'));
        } else {
            if (!empty($productIds)) {
                try {
                    $handler($productIds, $storeId);
                    $this->_getSession()->addSuccess($this->__('Prices has been updated.'));
                } catch (Exception $e) {
                    $this->_logException($e);
                    $this->_getSession()->addError($e->getMessage());
                }
            }
        }
        $this->_redirect('*/adminhtml_catalog/index', array('store' => $storeId));
    }

    /**
     * @return int
     */
    private function _getDefaultPercent()
    {
        return Mage::helper('example_catalog')->getDefaultPercentForMassUpdateOfPrices();
    }

    /**
     * @return Example_Catalog_Model_Price
     */
    private function _getPriceModel()
    {
        return Mage::getModel('example_catalog/Price');
    }

    //########################################
}