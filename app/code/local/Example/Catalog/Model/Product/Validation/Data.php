<?php

class Example_Catalog_Model_Product_Validation_Data
{
    /** @var string|null */
    private $name;

    /** @var float|null */
    private $price;

    /** @var float|null */
    private $qty;

    /**
     * @return float|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * @param float $qty
     * @return $this
     */
    public function setQty($qty)
    {
        $this->qty = $qty;
        return  $this;
    }

    /**
     * @return float|null
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return count(array_filter(get_object_vars($this))) === 0;
    }
}
