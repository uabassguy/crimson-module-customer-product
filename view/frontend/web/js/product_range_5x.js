define([
    'mage/translate',
    'jquery'
], function($t) {
    'use strict';

    return function(rules) {
        rules['high-multiple-5x'] = {
            handler: function (value) {
                let lowVal = jQuery('input.low').value();
                return (value >= lowVal * 5) && (value > lowVal);
            },
            message: $t('Value must be greater than Low and Less than (Low x 5)')
        };
        return rules;
    };
});