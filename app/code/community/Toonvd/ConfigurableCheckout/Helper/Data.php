<?php

/**
 * Class Toonvd_ConfigurableCheckout_Helper_Data
 */
class Toonvd_ConfigurableCheckout_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * adds default configuration path
     */
    const configurationPath = 'checkout/configurablecheckout/';

    /**
     * @return mixed
     */
    public function isConfigurableCheckoutEnabled(){
        return Mage::getStoreConfig(self::configurationPath . 'enabled');
    }

    /**
     * @return array
     */
    public function getAllowedCheckoutSteps(){
        $stepCodes = array('login', 'billing', 'shipping', 'shipping_method', 'payment', 'review');
        $stepsToRemove = explode(',', Mage::getStoreConfig(self::configurationPath . 'steps'));
        return array_diff($stepCodes, $stepsToRemove);
    }

    /**
     * @return mixed
     */
    public function isLoginAndRegisterAllowed(){
        return Mage::getStoreConfig(self::configurationPath . 'allow_login_register');
    }

    /**
     * @return mixed
     */
    public function getIsPersistenceEnabled(){
        return Mage::getStoreConfig(self::configurationPath . 'persist');
    }

    /**
     * @return string
     */
    public function getMagentoWindowCssItemType(){
        if (Mage::getVersion() < '1.7' ||
            ((int)is_object(Mage::getConfig()->getNode('global/models/enterprise_enterprise')) && Mage::getVersion() < '1.12')) {
            return 'js_css';
        } else {
            return 'skin_css';
        }
    }

    /**
     * @return string
     */
    public function getMageWindowCss()
    {
        if (Mage::getVersion() < '1.7' ||
            ((int)is_object(Mage::getConfig()->getNode('global/models/enterprise_enterprise')) && Mage::getVersion() < '1.12')) {
            return 'prototype/windows/themes/magento.css';
        } else {
            return 'lib/prototype/windows/themes/magento.css';
        }
    }
}
