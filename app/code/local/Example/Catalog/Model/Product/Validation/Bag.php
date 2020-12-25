<?php

class Example_Catalog_Model_Product_Validation_Bag
{
    /** @var Varien_Object */
    private $aggregator;

    private $error = false;

    public function __construct()
    {
        $this->aggregator = new Varien_Object();
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        return $this->aggregator->getMessage();
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->error = true;
        $this->aggregator->setMessage($message);
        return $this;
    }

    public function toJson()
    {
        $this->aggregator->setError($this->error);
        return $this->aggregator->toJson();
    }
}
