define(
    [
        'ko',
        'uiComponent',
        'underscore',
        'Magento_Checkout/js/model/step-navigator',
        'jquery',
        'Magento_Checkout/js/action/get-totals',
        'Magento_Checkout/js/model/full-screen-loader',
        'Magento_Checkout/js/action/get-payment-information'
    ],
    function (
        ko,
        Component,
        _,
        stepNavigator,
        $,
        getTotalsAction,
        fullScreenLoader,
        getPaymentInformationAction
    ) {
        'use strict';
        /**
         *
         * mystep - is the name of the component's .html template,
         * my_module - is the name of the your module directory.
         *
         */
        return Component.extend({
            defaults: {
                template: 'Retailexpress_Giftcard/mystep'
            },

            //add here your logic to display step,
            isVisible: ko.observable(false),


            initialize: function () {
                this._super();
                // register your step
                stepNavigator.registerStep(
                    //step code will be used as step content id in the component template
                    'mynewstep',
                    //step alias
                    'mynewstep',
                    //step title value
                    'Gift card',
                    //observable property with logic when display step or hide step
                    this.isVisible,

                    _.bind(this.navigate, this),

                    /**
                     * sort order value
                     * 'sort order value' < 10: step displays before shipping step;
                     * 10 < 'sort order value' < 20 : step displays between shipping and payment step
                     * 'sort order value' > 20 : step displays after payment step
                     */
                    15
                );

                return this;
            },

            /**
             * The navigate() method is responsible for navigation between checkout step
             * during checkout. You can add custom logic, for example some conditions
             * for switching to your custom step
             */
            navigate: function () {
                this.isVisible(true);
            },


            navigateToNextStep: function () {

                var code = $('#giftcard').val();
                if ( code == '' ) {
                    stepNavigator.next();
                    return;
                }
                $.ajax({
                    showLoader: true,
                    url: '/regiftcard/giftcard/check/code/' + code,
                    
                    type: "GET",
                    dataType: 'json'
                }).done(function (data) {
                    if ( data.success )
                    {
                        var deferred = $.Deferred();
                        getTotalsAction([], deferred);
                        getPaymentInformationAction(deferred);
                        $.when(deferred).done(function () {
                            stepNavigator.next();
                        });

                    }
                    else
                    {
                        alert('Voucher code is invalid or already claimed!');
                    }
                });
            }
        });
    }
);