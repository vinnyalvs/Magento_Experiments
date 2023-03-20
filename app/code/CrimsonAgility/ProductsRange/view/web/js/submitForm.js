require([
    'jquery',
    'mage/url'
], function ($, url) {
    alert("testeeee");
    $('#submit-btn').click(function (event) {
        alert("testeeee");
        $('#form-id').validate({
            rules: {
                lowprice: {
                    required: true,
                    min: 0
                },
                highprice: {
                    required: true,
                    max: $('input2').val()*5
                }
            },
            messages: {
                name: 'Please enter your name',
                email: {
                    required: 'Please enter your email address',
                    email: 'Please enter a valid email address'
                }
            }});

        event.preventDefault();
        let form = $('#search-products-form');
        let formData = form.serialize();
        let actionUrl = url.build('rest/V1/products/search');

        $.ajax({
            url: actionUrl,
            data: formData,
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {
                // add any loading animation here
            },
            success: function (response) {
                if (response.success) {
                    // handle successful response here
                    $('#response').html(response.message);
                } else {
                    // handle error response here
                    $('#response').html(response.message);
                }
            },
            error: function () {
                // handle ajax error here
            }
        });
    });
});
