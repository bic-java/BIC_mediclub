<?php

class BIC_Mediclub_Model_SkipCartObserver extends Varien_Object {

    public function clearCartItemsExceptCurrent(Varien_Event_Observer $observer) {
        $event = $observer->getEvent();
        $item = $event->getQuoteItem();
        $item->setQty(1)->save();

//        echo "<hr/>item</br>";
//        var_dump($item);
//        var_dump(get_class_methods($item));
//        exit();

        $cart = Mage::getSingleton('checkout/session');

        $quote = $cart->getQuote();

        $items = $quote->getItemsCollection();


        foreach ($items as $_item) {
            if ($_item->getId() != $item->getId()) {
                $_item->isDeleted(true);
            }
        }
    }

    public function redirectToCheckout(Varien_Event_Observer $observer) {
        $response = $observer->getResponse();

        $response->setRedirect(Mage::getUrl('checkout/onepage'));
        Mage::getSingleton('checkout/session')->setNoCartRedirect(true);
    }

}
