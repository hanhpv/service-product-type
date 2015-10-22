<?php

class Dtn_ServiceProduct_Model_Observer
{
    // make sure the service product quantity is 1
    public function salesQuoteItemQtySetAfter($observer)
    {
        /** @var Mage_Sales_Model_Quote_Item $item */
        $item = $observer->getItem();
        if ($item->getProduct()->isService()) {
            $item->setData('qty', 1);
        }
    }

    // make sure a service product is not mixed with any other products in shopping cart
    public function salesQuoteAddItem($observer)
    {
        /** @var Mage_Sales_Model_Quote_Item $item */
        $item = $observer->getData('quote_item');
        $quote = $item->getQuote();
        $helper = Mage::helper('service_product');
        $itemIsServiceProduct = $helper->isQuoteItemServiceProduct($item);
        $quoteHasItems = false;
        $quoteHasServiceProduct = false;
        foreach ($quote->getAllVisibleItems() as $_item) {
            // if this is the item being added, ignore it
            if ($item->compare($_item))
                continue;
            $quoteHasItems = true;
            if ($helper->isQuoteItemServiceProduct($_item)) {
                $quoteHasServiceProduct = true;
                break;
            }
        }
        if ($quoteHasServiceProduct && $itemIsServiceProduct) {
            Mage::throwException('The shopping cart can only contain one service at a time.');
        } elseif ($quoteHasServiceProduct && !$itemIsServiceProduct) {
            Mage::throwException('Services and other products may not be in the shopping cart at the same time.');
        } elseif ($quoteHasItems && !$quoteHasServiceProduct && $itemIsServiceProduct) {
            Mage::throwException('Services and other products may not be in the shopping cart at the same time.');
        }
    }
}