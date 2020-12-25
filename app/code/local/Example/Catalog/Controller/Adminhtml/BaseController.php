<?php

abstract class Example_Catalog_Controller_Adminhtml_BaseController
    extends Mage_Adminhtml_Controller_Action
{
    protected function _activateMenu()
    {
        $this->_setActiveMenu('example_catalog');
    }

    protected function _logException(\Exception $e)
    {
        Mage::logException($e);
    }
}