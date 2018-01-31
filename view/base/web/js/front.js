define([
    "jquery",
    "jquery/ui"
],function($){
$(window).load(function(){
    if ($('#customizationForm').length > 0)
    {
        $('#customizationForm').parent().hide();
    }
});
$(document).ready(function(){
    $('.fpd-content_only').on('click', function(e){
        e.preventDefault();
        window.parent.location = $(this).attr('href');
    });
    $('.scrollto-custom-button').on('click', function(e){
        e.preventDefault(); 
        var targetOffset =  $('.fpd-container').offset().top;
        $('html,body').animate({scrollTop: targetOffset}, 600);
    });
    //alert($('.salelabelinside').html());
    //$('.product media').prepend($('.salelabelinside').html());
	//alert("added");
    //$('.salelabelinside').remove();
});

function _addThousandSep(n){
    var rx=  /(\d+)(\d{3})/;
    return String(n).replace(/^\d+/, function(w){
        while(rx.test(w)){
            w= w.replace(rx, '$1'+thousandSeparator+'$2');
        }
        return w;
    });
};
/*
ajaxCart.overrideButtonsInThePage = function(){
    //for every 'add' buttons...
    $(document).off('click', '.ajax_add_to_cart_button').on('click', '.ajax_add_to_cart_button', function(e){
        e.preventDefault();
        var idProduct =  parseInt($(this).data('id-product'));
        var idProductAttribute =  parseInt($(this).data('id-product-attribute'));
        var minimalQuantity =  parseInt($(this).data('minimal_quantity'));
        if (!minimalQuantity)
            minimalQuantity = 1;
        if ($(this).prop('disabled') != 'disabled')
            ajaxCart.add(idProduct, idProductAttribute, false, this, minimalQuantity);
    });
    //for product page 'add' button...
    if ($('.cart_block').length) {
        $(document).off('click', '#add_to_cart button').on('click', '#add_to_cart button', function(e){
            e.preventDefault();
            var icc = $('#id_custom_customization').val();
            ajaxCart.add($('#product_page_product_id').val(), $('#idCombination').val(), true, null, $('#quantity_wanted').val(), null, icc);
        });
    }

    //for 'delete' buttons in the cart block...
    $(document).off('click', '.cart_block_list .ajax_cart_block_remove_link').on('click', '.cart_block_list .ajax_cart_block_remove_link', function(e){
        e.preventDefault();
        // Customized product management
        var customizationId = 0;
        var productId = 0;
        var productAttributeId = 0;
        var customizableProductDiv = $($(this).parent().parent()).find("div[data-id^=deleteCustomizableProduct_]");
        var idAddressDelivery = false;

        if (customizableProductDiv && $(customizableProductDiv).length)
        {
            var ids = customizableProductDiv.data('id').split('_');
            if (typeof(ids[1]) != 'undefined')
            {
                customizationId = parseInt(ids[1]);
                productId = parseInt(ids[2]);
                if (typeof(ids[3]) != 'undefined')
                    productAttributeId = parseInt(ids[3]);
                if (typeof(ids[4]) != 'undefined')
                    idAddressDelivery = parseInt(ids[4]);
            }
        }

        // Common product management
        if (!customizationId)
        {
            //retrieve idProduct and idCombination from the displayed product in the block cart
            var firstCut = $(this).parent().parent().data('id').replace('cart_block_product_', '');
            firstCut = firstCut.replace('deleteCustomizableProduct_', '');
            ids = firstCut.split('_');
            productId = parseInt(ids[0]);

            if (typeof(ids[1]) != 'undefined')
                productAttributeId = parseInt(ids[1]);
            if (typeof(ids[2]) != 'undefined')
                idAddressDelivery = parseInt(ids[2]);
        }

        // Removing product from the cart
        ajaxCart.remove(productId, productAttributeId, customizationId, idAddressDelivery);
    });
}

ajaxCart.add = function(idProduct, idCombination, addedFromProductPage, callerElement, quantity, whishlist, icc){

    if (addedFromProductPage && !checkCustomizations())
    {
        if (contentOnly)
        {
            var productUrl = window.document.location.href + '';
            var data = productUrl.replace('content_only=1', '');
            window.parent.document.location.href = data;
            return;
        }
        if (!!$.prototype.fancybox)
            $.fancybox.open([
                {
                    type: 'inline',
                    autoScale: true,
                    minHeight: 30,
                    content: '<p class="fancybox-error">' + fieldRequired + '</p>'
                }
            ], {
                padding: 0
            });
        else
            alert(fieldRequired);
        return;
    }

    //disabled the button when adding to not double add if user double click
    if (addedFromProductPage)
    {
        $('#add_to_cart button').prop('disabled', 'disabled').addClass('disabled');
        $('.filled').removeClass('filled');
    }
    else
        $(callerElement).prop('disabled', 'disabled');

    if ($('.cart_block_list').hasClass('collapsed'))
        this.expand();
    //send the ajax request to the server

    $.ajax({
        type: 'POST',
        headers: { "cache-control": "no-cache" },
        url: baseUri + '?rand=' + new Date().getTime(),
        async: true,
        cache: false,
        dataType : "json",
        data: 'controller=cart&add=1&ajax=true&qty=' + ((quantity && quantity != null) ? quantity : '1') + '&id_product=' + idProduct + '&token=' + static_token + ( (parseInt(idCombination) && idCombination != null) ? '&ipa=' + parseInt(idCombination): '' + '&id_customization=' + ((typeof customizationId !== 'undefined') ? customizationId : 0)) + '&id_customization=' + ((typeof icc !== 'undefined') ? icc : 0),
        success: function(jsonData,textStatus,jqXHR)
        {
            // add appliance to whishlist module
            if (whishlist && !jsonData.errors)
                WishlistAddProductCart(whishlist[0], idProduct, idCombination, whishlist[1]);

            if (!jsonData.hasError)
            {
                if (contentOnly)
                    window.parent.ajaxCart.updateCartInformation(jsonData, addedFromProductPage);
                else
                    ajaxCart.updateCartInformation(jsonData, addedFromProductPage);

                if (jsonData.crossSelling)
                    $('.crossseling').html(jsonData.crossSelling);

                if (idCombination)
                    $(jsonData.products).each(function(){
                        if (this.id != undefined && this.id == parseInt(idProduct) && this.idCombination == parseInt(idCombination))
                            if (contentOnly)
                                window.parent.ajaxCart.updateLayer(this);
                            else
                                ajaxCart.updateLayer(this);
                    });
                else
                    $(jsonData.products).each(function(){
                        if (this.id != undefined && this.id == parseInt(idProduct))
                            if (contentOnly)
                                window.parent.ajaxCart.updateLayer(this);
                            else
                                ajaxCart.updateLayer(this);
                    });
                if (contentOnly)
                    parent.$.fancybox.close();
            }
            else
            {
                if (contentOnly)
                    window.parent.ajaxCart.updateCart(jsonData);
                else
                    ajaxCart.updateCart(jsonData);
                if (addedFromProductPage)
                    $('#add_to_cart button').removeProp('disabled').removeClass('disabled');
                else
                    $(callerElement).removeProp('disabled');
            }

            emptyCustomizations();

        },
        error: function(XMLHttpRequest, textStatus, errorThrown)
        {
            var error = "Impossible to add the product to the cart.<br/>textStatus: '" + textStatus + "'<br/>errorThrown: '" + errorThrown + "'<br/>responseText:<br/>" + XMLHttpRequest.responseText;
            if (!!$.prototype.fancybox)
                $.fancybox.open([
                {
                    type: 'inline',
                    autoScale: true,
                    minHeight: 30,
                    content: '<p class="fancybox-error">' + error + '</p>'
                }],
                {
                    padding: 0
                });
            else
                alert(error);
            //reactive the button when adding has finished
            if (addedFromProductPage)
                $('#add_to_cart button').removeProp('disabled').removeClass('disabled');
            else
                $(callerElement).removeProp('disabled');
        }
    });
}*/
});