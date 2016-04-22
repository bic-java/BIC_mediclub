<?php

class BIC_Mediclub_Model_ConfirmOrderSms {

    /**
     * Send orderId by sms to the client
     *
     * @param Mage_Sales_Model_Order $order order object
     *
     * @return boolean
     */
    public function confirmOrderSms($order) {
        var_dump($order);
        exit();
        return true;
    }

}
