<?php

class Example_Catalog_Adminhtml_ProductController
    extends Example_Catalog_Controller_Adminhtml_BaseController
{
    //########################################

    public function editAction()
    {
        try {

            $product = $this->_getProductModel()->load(
                $this->_getInputProductId(),
                $this->_getInputStoreId()
            );

        } catch (Exception $e) {
            $this->_logException($e);
            $this->_getSession()->addError(Mage::helper('catalog')->__('This product no longer exists.'));
            $this->_redirect('*/adminhtml_catalog/');
            return;
        }

        Mage::register('current_product', $product);
        $this->loadLayout(array('default', strtolower($this->getFullActionName())));
        $this->_activateMenu();
        $this->renderLayout();
    }

    //########################################

    public function validateAction()
    {
        /** @var Example_Catalog_Model_Product_Validation_Data $validationData */
        $validationData = Mage::getModel('example_catalog/Product_Validation_Data');

        $validationData
            ->setName($this->getRequest()->getPost('name'))
            ->setPrice($this->getRequest()->getPost('price'))
            ->setQty($this->getRequest()->getPost('qty'));

        $response = $this->_getProductModel()->validate(
            $this->_getInputProductId(),
            $validationData,
            $this->_getInputStoreId()
        );

        if ($message = $response->getMessage()) {
            $this->_getSession()->addError($message);
            $this->_initLayoutMessages('adminhtml/session');
            $response->setMessage($this->getLayout()->getMessagesBlock()->getGroupedHtml());
        }

        $this->getResponse()->setBody($response->toJson());
    }

    public function saveAction()
    {
        $model = $this->_getProductModel();

        try {

            $request = $this->getRequest();

            $model->update(
                $productId   = $this->_getInputProductId(),
                $productName = $request->getPost('name'),
                $price       = (float) $request->getPost('price'),
                $qty         = (float) $request->getPost('qty'),
                $storeId     = $this->_getInputStoreId()
            );

            Mage::dispatchEvent('example_catalog_product_saved',
                compact('productId', 'productName', 'price', 'qty', 'storeId')
            );

            $this->_getSession()->addSuccess($this->__('The product has been saved.'));

        } catch (Exception $e) {
            $this->_logException($e);
            $this->_getSession()->addError($e->getMessage());
        }

        return $this->_redirect('*/adminhtml_product/edit', array(
            'store' => $storeId,
            'product_id' => $productId
        ));
    }

    //########################################

    /**
     * @return Example_Catalog_Model_Product
     */
    private function _getProductModel()
    {
        return Mage::getModel('example_catalog/Product');
    }


    /**
     * @return int
     * @throws Exception
     */
    private function _getInputProductId()
    {
        $productId = $this->getRequest()->getParam('product_id');

        if (is_null($productId)) {
            throw new \Exception('Unexpected product id');
        }

        return (int) $productId;
    }

    /**
     * @return int
     */
    private function _getInputStoreId()
    {
        return (int) $this->getRequest()->getParam('store', Mage_Core_Model_App::ADMIN_STORE_ID);
    }

    //########################################
}