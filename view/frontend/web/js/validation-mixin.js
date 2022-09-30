define(['jquery'], function($) {
    'use strict';

    return function(targetWidget) {
        $.validator.addMethod(
            'high-multiple-5x',
            function(value, element) {
                let lowVal = $('#low').val();;
                return (value <= lowVal * 5) && (value > lowVal);
            },
            $.mage.__('Value must be greater than Low and Less than (Low x 5)')
        )
        return targetWidget;
    }
});