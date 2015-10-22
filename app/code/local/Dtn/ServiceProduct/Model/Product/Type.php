<?php

class Dtn_ServiceProduct_Model_Product_Type extends Mage_Catalog_Model_Product_Type_Abstract
{
    const TYPE_CODE = 'service';

    protected function _prepareProduct(Varien_Object $buyRequest, $product, $processMode)
    {
        $product = $this->getProduct($product);
        $servicePrice = (float)$buyRequest->getServicePrice();
        $isStrictProcessMode = $this->_isStrictProcessMode($processMode);

        if ($buyRequest->getQty() > 1) {
            return Mage::helper('catalog')->__('The maximum qty of service product allowed in cart is 1.');
        }

        if (!$isStrictProcessMode || $servicePrice > 0) {
            $maxPrice = Mage::helper('service_product')->getMaxPrice();
            if ($maxPrice && $servicePrice > $maxPrice) {
                return Mage::helper('catalog')->__('Service price must not be greater than %d.', $maxPrice);
            }

            $products = parent::_prepareProduct($buyRequest, $product, $processMode);
            if (!isset($products[0])) {
                return Mage::helper('checkout')->__('Cannot process the item.');
            }
            return $products;
        }

        return Mage::helper('catalog')->__('Please specify the product price.');
    }
}