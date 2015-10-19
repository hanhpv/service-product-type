<?php
/** @var Mage_Catalog_Model_Resource_Setup $installer */
$installer = $this;
$installer->startSetup();
// apply attributes to new product type
$attributes = array(
    'price',
    'special_price',
    'special_from_date',
    'special_to_date',
    'minimal_price',
    'tax_class_id'
);
foreach ($attributes as $attributeCode) {
    $applyTo = explode(',', $installer->getAttribute('catalog_product', $attributeCode, 'apply_to'));
    if (!in_array(Dtn_ServiceProduct_Model_Product_Type::TYPE_CODE, $applyTo)) {
        $applyTo[] = Dtn_ServiceProduct_Model_Product_Type::TYPE_CODE;
        $installer->updateAttribute('catalog_product', $attributeCode, 'apply_to', implode(',', $applyTo));
    }
}
$installer->endSetup();