define([
    'jquery'
], function ($) {
    'use strict';

    $.widget('mage.checkLens', {
        options: {
            addRxLensButton: '#add-rx-lens-button'
        },

        /**
         * Check if product has lens condition
         * @private
         */
        _create: function () {
            var addRxLensButton = this.options.addRxLensButton,
                self = this;

            // Hide button add rx lens before check
            $(addRxLensButton).css('display', 'none');

            // First check for simple product page
            self.checkLens($('.page-title-wrapper .sku .value').text(), addRxLensButton);

            $(document).on('product_swatch_changed', function (e, sku) {
                if (sku) {
                    setTimeout(function () {
                        self.checkLens(sku, addRxLensButton);
                    }, 500);

                }
            });
        },

        /**
         * Toggle button Add Rx Lens
         * @param {Number} sku
         * @param {String} addRxLensButton
         */
        checkLens: function (sku, addRxLensButton) {
            var apiBaseUrl = this.options.apiBaseUrl;

            $.ajax({
                url: apiBaseUrl + '/api/flow/' + sku,
                dataType: 'JSON',
                type: 'GET',

                /** Show button if product has lens condition */
                success: function () {
                    $(addRxLensButton).css('display', 'block');
                },

                /** Hide button if product don't has lens condition */
                error: function () {
                    $(addRxLensButton).css('display', 'none');
                }
            });
        }
    });

    return $.mage.checkLens;
});
