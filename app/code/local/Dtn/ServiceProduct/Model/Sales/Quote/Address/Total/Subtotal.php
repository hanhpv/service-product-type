<?php

class Dtn_ServiceProduct_Model_Sales_Quote_Address_Total_Subtotal extends Mage_Sales_Model_Quote_Address_Total_Subtotal
{
    protected function _initItem($address, $item)
    {
        if ($item instanceof Mage_Sales_Model_Quote_Address_Item) {
            $quoteItem = $item->getAddress()->getQuote()->getItemById($item->getQuoteItemId());
        }
        else {
            $quoteItem = $item;
        }
        $product = $quoteItem->getProduct();
        $product->setCustomerGroupId($quoteItem->getQuote()->getCustomerGroupId());

        /**
         * Quote super mode flag mean what we work with quote without restriction
         */
        if ($item->getQuote()->getIsSuperMode()) {
            if (!$product) {
                return false;
            }
        }
        else {
            if (!$product || !$product->isVisibleInCatalog()) {
                return false;
            }
        }

        if ($quoteItem->getParentItem() && $quoteItem->isChildrenCalculated()) {
            $finalPrice = $quoteItem->getParentItem()->getProduct()->getPriceModel()->getChildFinalPrice(
                $quoteItem->getParentItem()->getProduct(),
                $quoteItem->getParentItem()->getQty(),
                $quoteItem->getProduct(),
                $quoteItem->getQty()
            );
            $item->setPrice($finalPrice)
                ->setBaseOriginalPrice($finalPrice);
            $item->calcRowTotal();
        } else if (!$quoteItem->getParentItem()) {
            $finalPrice = $product->getFinalPrice($quoteItem->getQty());
            $item->setPrice($finalPrice)
                ->setBaseOriginalPrice($finalPrice);
            $item->calcRowTotal();
            // add service margin for services
            $helper = Mage::helper('service_product');
            if ($helper->isQuoteItemServiceProduct($item)) {
                $serviceMargin = $helper->getServiceMargin();
                $item->setRowTotal($item->getRowTotal() + $serviceMargin);
                $item->setBaseRowTotal($item->getBaseRowTotal() + $serviceMargin);
            }
            // end
            $this->_addAmount($item->getRowTotal());
            $this->_addBaseAmount($item->getBaseRowTotal());
            $address->setTotalQty($address->getTotalQty() + $item->getQty());
        }

        return true;
    }
}