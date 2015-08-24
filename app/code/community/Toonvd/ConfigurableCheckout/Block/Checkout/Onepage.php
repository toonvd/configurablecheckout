<?php

/**
 * Class Toonvd_ConfigurableCheckout_Block_Checkout_Onepage
 */
class Toonvd_ConfigurableCheckout_Block_Checkout_Onepage extends Mage_Checkout_Block_Onepage
{
    /**
     * @var Mage_Core_Helper_Abstract
     */
    protected $_helper;

    /**
     * @var
     */
    protected $_allowedSteps;

    /**
     * Sets helper globally
     */
    public function __construct()
    {
        $this->_helper = Mage::helper('toonvd_configurablecheckout');
    }

    /**
     * @return mixed
     */
    public function getSteps()
    {
        if ($this->_helper->isConfigurableCheckoutEnabled()) {
            $allowedSteps = $this->_helper->getAllowedCheckoutSteps();

            if ($this->isCustomerLoggedIn()) {
                $allowedSteps = array_diff($allowedSteps, array('login'));
            } elseif (!in_array('login', $allowedSteps)) {
                $method = Mage_Checkout_Model_Type_Onepage::METHOD_GUEST;
                Mage::getSingleton('checkout/type_onepage')->saveCheckoutMethod($method);
            }

            $this->_allowedSteps = array_values($allowedSteps);

            foreach ($allowedSteps as $step) {
                $steps[$step] = $this->getCheckout()->getStepData($step);
            }
        } else {
            $steps = parent::getSteps();
        }

        return $steps;
    }

    /**
     * @return mixed
     */
    public function getActiveStep()
    {
        if ($this->_helper->isConfigurableCheckoutEnabled() && is_array($this->_allowedSteps)) {
            $activeStep = $this->_allowedSteps[0];
        } else {
            $activeStep = parent::getActiveStep();
        }
        return $activeStep;
    }
}
