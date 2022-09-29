var config = {
    config: {
        mixins: {
            'mage/validation': {
                'Crimson_ProductRange/js/validation-mixin': true
            },
            'Magento_Ui/js/lib/validation/rules': {
                'Crimson_ProductRange/js/product_range_5x': true
            }
        }
    },
    map: {
        '*':{
            product_range:'Crimson_ProductRange/js/product_range',
            "validation": "mage/validation/validation"
        }
    },
    shim:{
        'product_range':{
            deps: ['jquery']
        }
    }
}