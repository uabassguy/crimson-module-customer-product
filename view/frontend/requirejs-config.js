var config = {
    config: {
        mixins: {
            'mage/validation': {
                'Crimson_ProductRange/js/validation-mixin': true
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