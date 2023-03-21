require([
    'jquery',
    'mage/url',
], function ($, url) {
    $('#submit-btn').click(function (event) {
        let actionUrl = url.build('rest/V1/products/search');
        let payload = {
            "lowPrice": $("#input1").val(),
            "highPrice": $("#input2").val(),
            "sorting": $("#input3").val()
        };

        event.preventDefault();
        $.ajax({
            url: actionUrl,
            data: JSON.stringify(payload),
            type: 'POST',
            contentType: 'application/json',
            processData: false,
            beforeSend: function () {
                $("#label-loading").css("display", "block");
                $("#main-table").css("display", "none");
                $("#label-noresponse").css("display", "none");
                $("#main-table-body").empty();
            },
            success: function (response) {
                displayproductsTable(response);
            },
            error: function (response) {
                data = response.responseJSON
                if(data.message === "Parameter Validation Failed"){
                    $('#label-loading').append('<h3> Invalid Range Params, please try with different inputs </h3>');
                }
                else {
                    $('#label-loading').append('<h3> There is a problem in our website, please try again later. </h3>');
                }
            },
        });
    });

    function displayproductsTable(products){
        $("#label-loading").css("display", "none");
        if(products.length === 0) {
            $("#label-noresponse").css("display", "block");
        } else {
            $("#main-table").css("display", "block");
            $("#label-noresponse").css("display", "none");
            for (let product of products) {
                let sku_string = '<td class="row sku">' + product.sku + '</td>';
                let name_string = '<td class="row name">' + product.name + '</td>';
                let thumbnail_string = '<td class="row name">' + 'Foto' + '</td>';
                let price_string = '<td class="row name">' + product.price + '</td>';
                let url_string = '<td class="row name">' + '<a  href=' + product.url + '> Product page </a> </td>';
                let qty_string = '<td class="row name">' + product.qty + '</td>';
                let sku = $(sku_string);
                let name = $(name_string);
                let thumbnail = $(thumbnail_string);
                let price = $(price_string);
                let url = $(url_string);
                let qty = $(qty_string);

                let tr_1 = $('<tr>');
                let tr_2 =  $('</tr>');
                $('#main-table-body').append(tr_1);
                $('#main-table-body').append(thumbnail);
                $('#main-table-body').append(sku);
                $('#main-table-body').append(name);
                $('#main-table-body').append(qty);
                $('#main-table-body').append(price);
                $('#main-table-body').append(url);
                $('#main-table-body').append(tr_2);
            }
        }
    }


})
