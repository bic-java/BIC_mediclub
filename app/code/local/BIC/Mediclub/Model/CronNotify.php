<?php

class BIC_Mediclub_Model_CronNotify {

    public function notifyCodeExpiration() {
        $reminers = array(15, 30); //days remaning when send notification
        foreach ($reminers as $remaningDays) {
            $orders = $this->getOrdersExpiresIn($remaningDays);
            foreach ($orders as $order) {
                var_dump($order->getCustomerEmail());
                var_dump($order->getCustomerFirstname());
                var_dump($order->getCustomerLastname());
                var_dump($order->getIncrementId());
                echo '<pre>';
                print_r($order->toArray());
                echo '</pre>';

            $body = "Hi, tu compra numero {$order->getIncrementId()} está por caducar"
            . ", quedan $remaningDays para canjearla, si no lo haces antes de este tiempo se perderá y ya no podras disfrutar del servicio que has adquirido";
                $mail = Mage::getModel('core/email');
                $mail->setToName($order->getCustomerFirstname().' '.$order->getCustomerLastname());
                $mail->setToEmail($order->getCustomerEmail());
                $mail->setBody($body);
                $mail->setSubject('Tu compra caducará pronto');
                $mail->setType('text'); // You can use 'html' or 'text'

                try {
                    $mail->send();
                    Mage::getSingleton('core/session')->addSuccess('Your request has been sent');
                    $this->_redirect('');
                } catch (Exception $e) {
                    Mage::getSingleton('core/session')->addError('Unable to send.');
                    $this->_redirect('');
                }
//            var_dump(get_class_methods($order));
//            $statusHistory = $order->getStatusHistoryCollection();
//            var_dump($statusHistory->toArray());
            }
        }

        return TRUE;
    }

    /**
     * devuelve las ordenes que caducan dentro de x dias
     * la caducidad es de 60 dias a partir de que cambia su status a 'complete'
     * @param type $days dias restantes para que caduque la orden
     */
    function getOrdersExpiresIn($daysRemaning) {

        $expiration = 60;
        if ($daysRemaning > $expiration) {
            throw new Exception('$daysRemaning no puede ser mayor a ' . $expiration . ' porque la caducidad es de ' . $expiration . ' dias');
        }

        $completedAgo = $expiration - $daysRemaning;

        $dateCompletedAt = date('Y-m-d', strtotime("-$completedAgo day"));
        $conn = Mage::getSingleton('core/resource')->getConnection('core_setup');
        $profiler = $conn->getProfiler();
        $profiler->setEnabled(true);


        /**
         * @var $ordersModel
         * @type Mage_Sales_Model_Order
         */
        $ordersModel = new Mage_Sales_Model_Order();
        $ordersModel = Mage::getModel('sales/order');

        $orders = $ordersModel->getCollection()
                ->addFieldToFilter('main_table.status', 'complete')
        ;

        $select = $orders->getSelect();
        $select
                ->join(array('sh' => 'sales_flat_order_status_history')
                        , "sh.parent_id=main_table.entity_id AND sh.status='complete'"
                        , array('completed_at' => 'sh.created_at'))
                ->joinLeft(array('sh2' => 'sales_flat_order_status_history')
                        , "(main_table.entity_id = sh2.parent_id AND sh.status='complete' AND 
                        (sh.created_at < sh2.created_at OR sh.created_at = sh2.created_at AND sh.entity_id < sh2.entity_id))"
                        , array())
                ->where('cast(sh.created_at as date)=?', $dateCompletedAt)
                ->where("sh.status='complete'")
                ->where('sh2.entity_id IS NULL');

        return $orders;
    }

}
