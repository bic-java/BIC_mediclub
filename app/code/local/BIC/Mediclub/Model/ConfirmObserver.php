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
//        echo '<hr/>observer event<br/>';
//        var_dump($observer);

        echo $observer->toJson();

        echo '<hr/>order<br/>';
        $orderData = $observer->getPayment()->getOrder()->getData();
        var_dump($orderData);
//        var_dump(get_class_methods($observer->getPayment()->getOrder()->getData()));

        $customerId = $orderData['customer_id'];
        $orderId = $orderData['increment_id'];

        $customer = Mage::getModel('customer/customer')
                ->load($customerId);

        $mobileNumber = $customer->getResource()
                ->getAttribute('mobile_number')
                ->getFrontend()
                ->getValue($customer);
        if ($mobileNumber) {

            Mage::getModel('BIC_Mediclub_Model_ConfirmOrderSms')
                    ->confirmOrderSms($mobileNumber, $orderId);
        }
        exit();
        return true;
    }

}
