<?php

/**
 * Class Toonvd_ConfigurableCheckout_Model_Observer
 */
class Toonvd_ConfigurableCheckout_Model_Observer extends Varien_Event_Observer
{
    /**
     * @var Mage_Core_Helper_Abstract
     */
    protected $_helper;

    /**
     * Sets helper globally
     */
    public function __construct()
    {
        $this->_helper = Mage::helper('toonvd_configurablecheckout');
    }

    /**
     * @param $observer
     *
     * Inject js and stepsarray
     */
    public function core_block_abstract_to_html_after($observer)
    {
        if ($observer->getBlock() instanceof Mage_Checkout_Block_Onepage_Billing && $this->_helper->isConfigurableCheckoutEnabled()) {
            $html = $observer->getTransport()->getHtml();
            $billing_html = '';
            if ($this->_helper->isLoginAndRegisterAllowed() && !Mage::getSingleton('customer/session')->isLoggedIn()) {
                $billing_html = Mage::app()->getLayout()->createBlock('core/template')->setTemplate('toonvd/configurablecheckout/actions.phtml')->toHtml();
            }
            $billing_html .= $html;
            if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
                $billing_html .= Mage::app()->getLayout()->createBlock('core/template')->setTemplate('toonvd/configurablecheckout/login.phtml')->toHtml();
            }
            $billing_html .= '<script>window.configSteps=["' . implode('","', $this->_helper->getAllowedCheckoutSteps()) . '"];</script>';
            $billing_html .= '<script type="text/javascript" src="' . Mage::getDesign()->getSkinUrl('js/toonvd/configurablecheckout.js') . '"></script>';
            $observer->getTransport()->setHtml($billing_html);
        }
    }

    /**
     *
     */
    public function controller_action_predispatch_checkout_onepage_saveBilling()
    {
        if ($this->_helper->isConfigurableCheckoutEnabled()) {
            $post = Mage::app()->getRequest()->getPost();
            if (!empty($post['checkout_method']) && $post['checkout_method'] == 'guest') {
                $method = Mage_Checkout_Model_Type_Onepage::METHOD_GUEST;
            } else {
                $method = Mage_Checkout_Model_Type_Onepage::METHOD_REGISTER;
            }
            Mage::getSingleton('checkout/type_onepage')->saveCheckoutMethod($method);
        }
    }
}