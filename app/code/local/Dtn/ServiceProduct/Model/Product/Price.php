<?php

class Dtn_ServiceProduct_Model_Product_Price extends Mage_Catalog_Model_Product_Type_Price
{
    public function getFinalPrice($qty = null, $product)
    {
        // if product was added to cart, get the price from user input, otherwise returns the price was set in admin
        if ($product->getCustomOption('info_buyRequest')) {
            $price = 0.0;
            $buyRequest = unserialize($product->getCustomOption('info_buyRequest')->getValue());
            if (is_array($buyRequest) && isset($buyRequest['service_price'])) {
                $price += $buyRequest['service_price'];
            }
            return $price;
        }
        return parent::getFinalPrice($qty, $product);
    }
}