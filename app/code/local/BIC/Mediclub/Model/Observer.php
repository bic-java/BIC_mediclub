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


        echo '<hr/>observer event vars:<br/>';
        var_dump(get_object_vars($observer));

        echo '<hr/>observer event methods:<br/>';
        var_dump(get_class_methods($observer));

        $attrMovileNumber=$observer->getCart()->getCustomerSession()->getCustomer()->getAttribute('mobile_number');
//        var_dump($attrMovileNumber->getData());
//        var_dump(get_class_methods($attrMovileNumber));

        echo $observer->toJson();

        $url = 'http://localhost/~eislas/dumpRequest.php';
//        $url = 'https://api.infobip.com/sms/1/text/single';
        $apiUser = 'MedicaVrim';
        $apiPassword = 'Infobip99';
        $fields = array(
            'from' => 'MediClub',
            'to' => '522223765692',
            'text' => 'sms enviado desde magento'
        );


        $headers = array(
//            'Content-Type: application/x-www-form-urlencoded',
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Basic ' . base64_encode($apiUser . ':' . $apiPassword)
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// in real life you should use something like:
// curl_setopt($ch, CURLOPT_POSTFIELDS, 
//          http_build_query(array('postvar1' => 'value1')));
// receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        $server_output = curl_exec($ch);

        curl_close($ch);

// further processing ....
        echo '<hr/>Request output:<br/>' . $server_output;


        $x = new ASD();
        throw new Exception('hardcoded Observer exception');
        exit();
        return true;
    }

}
