<?php

//echo 'Running This Upgrade: '.get_class($this)."\n <br /> \n";
//die("Exit for now");  

$installer = $this;

$installer->startSetup();

//$runed = $installer->run("
// DROP TABLE IF EXISTS {$this->getTable('web')};
//    ");



$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$entityTypeId = $setup->getEntityTypeId('customer');
$attributeSetId = $setup->getDefaultAttributeSetId($entityTypeId);
$attributeGroupId = $setup->getDefaultAttributeGroupId($entityTypeId, $attributeSetId);

$installer->addAttribute("customer", "mobile_number", array(
    "type" => "varchar",
    "backend" => "",
    "label" => "Teléfono celular",
    "input" => "text",
    "source" => "",
    "visible" => true,
    "required" => false,
    "default" => "",
    "frontend" => "",
    "unique" => false,
    "note" => "Para recibir notificaciones via sms proporciona tu numero celular a 10 digitos"
));

$attribute = Mage::getSingleton("eav/config")->getAttribute("customer", "mobile_number");


$setup->addAttributeToGroup(
        $entityTypeId, $attributeSetId, $attributeGroupId, 'mobile_number', '4'  //sort_order
);

$used_in_forms = array();

$used_in_forms[] = "adminhtml_customer";
$used_in_forms[] = "checkout_register";
$used_in_forms[] = "customer_account_create";
$used_in_forms[] = "customer_account_edit";
$used_in_forms[] = "adminhtml_checkout";
$attribute->setData("used_in_forms", $used_in_forms)
        ->setData("is_used_for_customer_segment", true)
        ->setData("is_system", 0)
        ->setData("is_user_defined", 1)
        ->setData("is_visible", 1)
        ->setData("sort_order", 4)
;
$attribute->save();



$installer->endSetup();
