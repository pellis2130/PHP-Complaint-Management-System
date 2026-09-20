<?php

class Product
{
    private $productId;
    private $productName;
    private $description;
    private $active;

    public function __construct(
        $productId = null,
        $productName = '',
        $description = '',
        $active = 1
    ) {
        $this->productId = $productId;
        $this->productName = $productName;
        $this->description = $description;
        $this->active = $active;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function getProductName()
    {
        return $this->productName;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    public function setProductName($productName)
    {
        $this->productName = $productName;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }
}

?>