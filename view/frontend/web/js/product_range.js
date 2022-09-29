define(["jquery", "domReady!","product_range"], function($,dom,product_range){

    $(document).on('click', '#range-submit-btn', function(e){
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
                //location.reload();
                alert(data);
            }
        });
        e.preventDefault();
    });

})