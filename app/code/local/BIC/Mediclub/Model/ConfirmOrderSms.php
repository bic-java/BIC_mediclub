<?php

class BIC_Mediclub_Model_ConfirmOrderSms {

    /**
     * Send orderId by sms to the client
     *
     * @param Mage_Sales_Model_Order $order order object
     *
     * @return boolean
     */
    public function confirmOrderSms($mobileNumber, $orderId) {
        $url = 'http://localhost/~eislas/dumpRequest.php';
//        $url = 'https://api.infobip.com/sms/1/text/single';
        $apiUser = 'MedicaVrim';
        $apiPassword = 'Infobip99';
        $fields = array(
            'from' => 'MediClub',
            'to' => $mobileNumber,
            'text' => "Ya puedes canjear tu pedido $orderId, se ha confirmado el pago"
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
        return true;
    }

}
