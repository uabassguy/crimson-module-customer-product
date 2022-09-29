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
        }
    },
    shim:{
        'product_range':{
            deps: ['jquery']
        }
    }
}