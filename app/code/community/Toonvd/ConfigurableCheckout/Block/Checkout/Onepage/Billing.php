<?php

/**
 * Class Toonvd_ConfigurableCheckout_Block_Checkout_Onepage_Billing
 */
class Toonvd_ConfigurableCheckout_Block_Checkout_Onepage_Billing extends Mage_Checkout_Block_Onepage_Billing
{

    /**
     * @return Mage_Sales_Model_Quote_Address
     */
    public function getAddress()
    {
        if (is_null($this->_address)) {
            if ($this->isCustomerLoggedIn()) {
                $this->_address = $this->getQuote()->getBillingAddress();
                if (!$this->_address->getFirstname()) {
                    $this->_address->setFirstname($this->getQuote()->getCustomer()->getFirstname());
                }
                if (!$this->_address->getLastname()) {
                    $this->_address->setLastname($this->getQuote()->getCustomer()->getLastname());
                }
            } elseif (Mage::helper('toonvd_configurablecheckout')->getIsPersistenceEnabled()) {
                $this->_address = $this->getQuote()->getBillingAddress();
            } else {
                $this->_address = Mage::getModel('sales/quote_address');
            }
        }
        return $this->_address;
    }
}