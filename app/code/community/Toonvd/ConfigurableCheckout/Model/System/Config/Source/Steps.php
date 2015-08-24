<?php

/**
 * Class Toonvd_ConfigurableCheckout_Model_System_Config_Source_Steps
 */
class Toonvd_ConfigurableCheckout_Model_System_Config_Source_Steps{

    /**
     * @var Mage_Core_Helper_Abstract
     */
    protected $_helper;

    /**
     * Sets helper globally
     */
    public function __construct(){
        $this->_helper = Mage::helper('toonvd_configurablecheckout');
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'login', 'label' => $this->_helper->__('Login')),
            array('value' => 'shipping', 'label' => $this->_helper->__('Shipping Address')),
            array('value' => 'shipping_method', 'label' => $this->_helper->__('Shipping Method')),
            array('value' => 'payment', 'label' => $this->_helper->__('Payment')),
            array('value' => 'review', 'label' => $this->_helper->__('Review')),
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'login' => $this->_helper->__('Login'),
            'shipping' => $this->_helper->__('Shipping Address'),
            'shipping_method' => $this->_helper->__('Shipping Method'),
            'payment' => $this->_helper->__('Payment'),
            'review' => $this->_helper->__('Review'),
        );
    }
}