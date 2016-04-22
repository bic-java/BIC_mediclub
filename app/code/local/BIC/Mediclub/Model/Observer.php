<?php

class BIC_Mediclub_Model_Observer {

    /**
     * envía el numero de orden por sms al cliente
     *
     * @param Varien_Event_Observer $observer observer object
     *
     * @return boolean
     */
    public function customerLogin(Varien_Event_Observer $observer) {
        var_dump($observer);
        $x=new ASD();
        throw new Exception('hardcoded Observer exception');
        exit();
        return true;
    }

}
