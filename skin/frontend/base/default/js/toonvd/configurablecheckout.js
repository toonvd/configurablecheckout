Checkout.addMethods({
    initialize: function (accordion, urls) {
        this.accordion = accordion;
        this.progressUrl = urls.progress;
        this.reviewUrl = urls.review;
        this.saveMethodUrl = urls.saveMethod;
        this.failureUrl = urls.failure;
        this.billingForm = false;
        this.shippingForm = false;
        this.syncBillingShipping = false;
        this.method = '';
        this.payment = '';
        this.loadWaiting = false;
        this.steps = window.configSteps;
        //We use billing as beginning step since progress bar tracks from billing
        this.currentStep = 'billing';

        this.accordion.sections.each(function (section) {
            Event.observe($(section).down('.step-title'), 'click', this._onSectionClick.bindAsEventListener(this));
        }.bind(this));

        this.accordion.disallowAccessToNextSections = true;
        if (window.configSteps[0] == 'billing' && $('register-customer-password')) {
            Element.hide('register-customer-password');
            this.gotoSection('billing', true);
        }
        if ($('billing-new-address-form') && $('configurablecheckout_select')) {
            var selectMethod = $$('.configurablecheckout_select')[0];
            $('billing-new-address-form').insertBefore(selectMethod, $('billing-new-address-form').firstChild);
        }
    },
    togglePassword: function () {
        if ($('login:guest') && $('login:guest').checked) {
            Element.hide('register-customer-password');
        } else if ($('login:register') && ($('login:register').checked || $('login:register').type == 'hidden')) {
            Element.show('register-customer-password');
        }
    },
    popupLoginWindow: function (url) {
        this.modal = Dialog.info(null, {
            closable: true,
            resizable: false,
            draggable: false,
            className: 'magento',
            windowClassName: 'popup-window',
            title: 'Login',
            width: 400,
            height: 300,
            zIndex: 1000,
            recenterAuto: true,
            hideEffect: Element.hide,
            showEffect: Element.show,
            id: 'toonvd_configurablecheckout_login'
        });
        this.modal.setContent($('configurablecheckout-login'));
        $$('.configurablecheckout-login .actions button')[0].on("click", function (event) {
            $('login-please-wait').show();
            new Ajax.Request(
                url,
                {
                    method: 'post',
                    onComplete: function (transport) {
                        if (transport.responseText == 1) {
                            location.reload();
                        }
                        else {
                            $$('.errorMessages')[0].update(transport.responseText);
                            $('login-please-wait').hide();
                        }
                    },
                    parameters: Form.serialize($('configurablecheckout-login'))
                }
            );
        });
    }
});