<?php

class Dtn_ServiceProduct_Model_Product extends Aitoc_Aitproductslists_Model_Rewrite_CatalogProduct
{
    public function isService()
    {
        return $this->getTypeId() == Dtn_ServiceProduct_Model_Product_Type::TYPE_CODE;
    }
}