<?php

class Dtn_ServiceProduct_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function quoteHasServiceProduct()
    {
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        if (!$quote->hasData('has_service_product')) {
            $quote->setData('has_service_product', false);
            foreach ($quote->getAllVisibleItems() as $item) {
                if ($this->isQuoteItemServiceProduct($item)) {
                    $quote->setData('has_service_product', true);
                    break;
                }
            }
        }

        return $quote->getData('has_service_product');
    }

    /**
     * @param Mage_Sales_Model_Quote_Item $item
     */
    public function isQuoteItemServiceProduct($item)
    {
        return $item->getProduct()->isService();
    }

    public function getMaxPrice()
    {
        return (float)Mage::getStoreConfig('service_product/configuration/max_price');
    }

    public function getServiceMargin()
    {
        return (float)Mage::getStoreConfig('service_product/configuration/service_margin');
    }
}