<?php

/**
 * Class Toonvd_ConfigurableCheckout_IndexController
 */
class Toonvd_ConfigurableCheckout_IndexController extends Mage_Core_Controller_Front_Action{

    /**
     *
     */
    public function loginAction(){
        if($this->_validateFormKey()){
            $session = Mage::getSingleton('customer/session');

            if ($this->getRequest()->isPost()) {
                $login = $this->getRequest()->getPost('login');
                if (!empty($login['username']) && !empty($login['password'])) {
                    try {
                        echo $session->login($login['username'], $login['password']);
                    } catch (Mage_Core_Exception $e) {
                        switch ($e->getCode()) {
                            case Mage_Customer_Model_Customer::EXCEPTION_EMAIL_NOT_CONFIRMED:
                                $value = $this->_getHelper('customer')->getEmailConfirmationUrl($login['username']);
                                $message = $this->_getHelper('customer')->__('This account is not confirmed. <a href="%s">Click here</a> to resend confirmation email.', $value);
                                break;
                            case Mage_Customer_Model_Customer::EXCEPTION_INVALID_EMAIL_OR_PASSWORD:
                                $message = $e->getMessage();
                                break;
                            default:
                                $message = $e->getMessage();
                        }
                        echo $message;
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                } else {
                    echo $this->__('Login and password are required.');
                }
            }
        }
        else{
            $this->_redirectReferer();
        }
        return;
    }

    /**
     * Validate Form Key
     *
     * @return bool
     */
    protected function _validateFormKey()
    {
        if (!($formKey = $this->getRequest()->getParam('form_key', null))
            || $formKey != Mage::getSingleton('core/session')->getFormKey()) {
            return false;
        }
        return true;
    }
}