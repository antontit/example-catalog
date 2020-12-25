<?php

use Example_Catalog_Model_Product_Validation_Data as ValidationData;
use Example_Catalog_Model_Product_Validation_Bag as ValidationBag;
use Mage_Catalog_Model_Product_Type_Simple as SimpleType;


class Example_Catalog_Model_Product
{
    /**
     * @param int $productId
     * @param int|null $storeId
     * @return Mage_Catalog_Model_Product
     */
    public function load($productId, $storeId = null, $editMode = false)
    {
        $storeId = is_null($storeId) ? Mage_Core_Model_App::ADMIN_STORE_ID : $storeId;

        if ($productId <= 0) {
            throw new \InvalidArgumentException('The Product ID is not set.');
        }

        /** @var Mage_Catalog_Model_Product $product */
        $product = Mage::getModel('catalog/product')->setStoreId($storeId);

        if ($editMode) {
            $product->setData('_edit_mode', true);
        }

        $product->load($productId);

        return $product;
    }

    /**
     * @param int $productId
     * @param ValidationData $validationData
     * @param int|null $storeId
     * @return ValidationBag
     */
    public function validate($productId, ValidationData $validationData, $storeId = null)
    {
        $bag = new ValidationBag();

        if ($validationData->isEmpty()){
            return $bag->setMessage('Inputs are not filled.');
        }

        $product = $this->load($productId, $storeId, true);

        if (!($product->getTypeInstance() instanceof SimpleType)) {
            $currentType = $product->getTypeId();
            return $bag->setMessage("The product must has simple type. Current type is '$currentType'.");
        }

        if ($name = $validationData->getName()) {
            $product->setData('name', $name);
        }

        if ($price = $validationData->getPrice()) {
            $product->setData('price', $price);
        }

        if ($qty = $validationData->getQty()) {
            $product->setData('stock_data', compact('qty'));
        }

        try {
            $product->validate();
        } catch (\Exception $e) {
            $bag->setMessage($e->getMessage());
        }

        return $bag;
    }

    /**
     * @param int $productId
     * @param string $name
     * @param float|string $price
     * @param float|string $qty
     * @param int|null $store
     * @return Mage_Catalog_Model_Product
     * @throws Exception
     */
    public function update($productId, $name, $price, $qty, $store = null)
    {
        $product = $this->load($productId, $store, true);

        $product->addData(array(
            'name' => $name,
            'price' => $price,
            'stock_data' => compact('qty')
        ));

        return $product->save();
    }
}
