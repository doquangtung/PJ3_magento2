define(
    [
        'LoyaltyProgram_RewardPoint/js/view/checkout/summary/custom_amount'
    ],
    function (Component) {
        'use strict';

        return Component.extend({

            /**
             * @override
             */
            isDisplayed: function () {
                return this.getPureValue() !== 0;
            }
        });
    }
);