<?php

class BIC_Mediclub_Model_ConfirmObserver {

    /**
     * envía el numero de orden por sms al cliente
     *
     * @param Varien_Event_Observer $observer observer object
     *
     * @return boolean
     */
    public function confirmOrder(Varien_Event_Observer $observer) {
        //var_dump($observer);
        
        $order = $observer->getEvent()->getOrder();

        Mage::getModel('BIC_Mediclub_Model_ConfirmOrderSms')
                ->confirmOrderSms($order);

        exit();
        return true;
    }

}
