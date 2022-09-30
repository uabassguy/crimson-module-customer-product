define([
    "jquery",
    "domReady!",
    "product_range",
    "mage/mage",
    "mage/validation"
], function($,dom,product_range){

    $(document).on('click', '#range-submit-btn', function(e){
        var dataForm = $('#my-form');
        if (dataForm.validation('isValid')) {
            var ajxurl = $('#my-form').attr('action');
            var formdata = new FormData(jQuery('#my-form')[0]);
            $.ajax({
                url: ajxurl,
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formdata,
                showLoader: true,
                success: function(data){
                    dataForm.validation('clearError');
                    $('#product-result').html(data.html);
                }
            });
        }
        e.preventDefault();
    });

})