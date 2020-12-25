<?php

class Example_Catalog_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * @return int
     */
    public function getDefaultPercentForMassUpdateOfPrices()
    {
        $path = 'default/example_catalog/mass_action/update_price/percent';
        $percent = Mage::getConfig()->getNode($path);

        if (is_null($percent)) {
            throw new \LogicException('The percent is not defined.');
        }

        if (((int) $percent) <= 0){
            throw new \LogicException('The percent must be more zero.');
        }

        return (int) $percent;
    }
}