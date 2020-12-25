<?php

class Example_Catalog_Model_Price
{
    /**
     * @param $productsIds
     * @param $percent
     * @param int|null $storeId
     */
    public function massIncreasePrice($productsIds, $percent, $storeId = null)
    {
        $this->_massUpdate($productsIds, $percent, '+', $storeId);
    }

    /**
     * @param $productsIds
     * @param $percent
     * @param int|null $storeId
     */
    public function massDecreasePrice($productsIds, $percent, $storeId = null)
    {
        $this->_massUpdate($productsIds, $percent, '-', $storeId);
    }

    /**
     * @param array|int[] $productIds
     * @param int $percent
     * @param string $operator
     * @param int|null $storeId
     * @throw \InvalidArgumentException
     */
    private function _massUpdate($productIds, $percent, $operator, $storeId = null)
    {
        if (count($productIds) === 0) {
            return;
        }

        $productIds = array_map('intval', $productIds);

        if ($operator !== '+' && $operator !== '-') {
            throw new \InvalidArgumentException("The operator '$operator' is invalid.");
        }

        if (!is_int($percent) || $percent <= 0) {
            throw new \InvalidArgumentException("The percent '$percent' is invalid.");
        }

        $storeId = is_null($storeId) ? Mage_Core_Model_App::ADMIN_STORE_ID : $storeId;

        /** @var Mage_Core_Model_Resource $coreResource */
        $coreResource = Mage::getSingleton('core/resource');
        $connection = $coreResource->getConnection('core_write');
        $decimalTable = $coreResource->getTableName('catalog_product_entity_decimal');
        $eavAttributeTable = $coreResource->getTableName('eav_attribute');

        $ids = implode(',', $productIds);
        $percent = $percent * 0.01;

        $sql = "UPDATE $decimalTable val" .
            " SET val.value = val.value $operator (val.value * ?)" .
            " WHERE  val.attribute_id = (" .
            "   SELECT attribute_id FROM $eavAttributeTable eav" .
            "   WHERE eav.attribute_code = ?" .
            " ) AND val.entity_id IN ($ids)" .
            " AND val.store_id = ?";

        $connection->query($sql, array($percent, 'price', $storeId));
    }
}
