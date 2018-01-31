define([
    "jquery",
    "jquery/ui",
	"cust_pdesign"
],function($){
	var fancyProductDesigner,
		$orderImageList,
		loadingProduct = false,
		currentItemId = '',
		orderId = thepostid,
		isReady = false,
		stageWidth = stage_width,
		stageHeight = stage_height;
	jQuery(document).ready(function() {
    
	var mainhtml = $('.changedivpoistion').html();    
    $('#start_products').append(mainhtml);
    $('.changedivpoistion').remove();
    var $fancyProductDesigner = jQuery('#fpd-order-designer'),
        $customElementsList = jQuery('#fpd-custom-elements-list'),
        customElements = null;

    $orderImageList = jQuery('#fpd-order-image-list');

    jQuery(document).ajaxError( function(e, xhr, settings, exception) {
        //console.log(e, xhr, settings, exception);
    });

    fancyProductDesigner = $fancyProductDesigner.fancyProductDesigner({
        width: stageWidth,
        stageHeight: stageHeight,
        editorMode: '#fpd-editor-box-wrapper',
        fonts: [enabled_fonts],
        templatesDirectory: template_dir,
        tooltips: true
    }).data('fancy-product-designer');

    //api buttons first available when
    $fancyProductDesigner.on('ready', function() {
        isReady = true;
    })
    .on('productCreate', function() {

        $customElementsList.empty();

        customElements = fancyProductDesigner.getCustomElements();
        for(var i=0; i < customElements.length; ++i) {
            var customElement = customElements[i].element;
            $customElementsList.append('<li><a href="#">'+customElement.title+'</a></li>');
        }

        loadingProduct = false;

    });

    jQuery('.fancy-product').on('click', '.fpd-show-order-item', function(evt) {
        evt.preventDefault();
        if(	isReady && !loadingProduct ) {
            var $this = jQuery(this);
            $this.data('defaultText', $this.text()).text(loading_data);

            currentItemId = $this.data('id_customization');
            jQuery.ajax({
                url: fpd_admin_opts.adminAjaxUrl,
                data: {
                    action: 'fpd_loadorder',                
                    ic: $this.data('id_customization'),
                    pi: $this.data('pi'),
                    pai: $this.data('pai'),
                    form_key : fpd_admin_opts.checkToken
                },
                type: 'post',
                dataType: 'json',
                complete: function(data) {                    
                    if (typeof data.responseJSON.message != 'undefined' && data.responseJSON.message == 'error') {
                        fpdMessage(fpd_admin_opts.tryAgain, 'error');
                    } else if(data == undefined || data.responseJSON) {
                        $('html, body').animate({
                            scrollTop: $("#fpd-order").offset().top
                        }, 300);
                        fpdLoadOrder(JSON.parse(data.responseJSON.order_data));
                    }
                    else {
                        fpdMessage(cound_not, 'error');
                    }
                    $this.text($this.data('defaultText'));
                }
            });
        }
    });

    //change stage dimensions
    jQuery('#fpd-stage-width, #fpd-stage-height').on('change keyup', function(evt) {

        evt.preventDefault();

        if(	_checkAPI() ) {

            var $this = jQuery(this);

            if($this.attr('id') === 'fpd-stage-width') {
                stageWidth = parseInt($this.val() ? $this.val() : $this.attr('placeholder'));
            }
            else {
                stageHeight = parseInt($this.val() ? $this.val() : $this.attr('placeholder'));
            }

            fancyProductDesigner.setStageDimensions(stageWidth, stageHeight);
            jQuery('input[name="fpd_scale"]').keyup();

        }

    });

    jQuery('#fpd-create-new-fp').click(function(evt) {

        evt.preventDefault();

        if(	_checkAPI() ) {

            var $panel = jQuery(this).parents('.fpd-inner-panel:first');
                addToLibrary = confirm(fpd_admin_opts.addToLibrary);

            fpdBlockPanel($panel);

            fpdAddProduct(function(data) {

                if(data) {

                    fpdAddViews(
                        data.id,
                        fancyProductDesigner.getProduct(),
                        addToLibrary,
                        //view added
                        function(data) {
                        },
                        //complete
                        function() {
                            fpdUnblockPanel($panel);
                        }
                    );

                }
                else {
                    fpdUnblockPanel($panel);
                }

            });

        }

    });

    //EXPORT
    jQuery('[name="fpd_output_file"]').change(function() {

        if(jQuery('[name="fpd_output_file"]:checked').val() == 'pdf') {
            jQuery('#fpd-pdf-width').parents('label:first').show();
            jQuery('#fpd-pdf-height').parents('label:first').show();
            jQuery('#fpd-pdf-dpi').parents('label:first').show();
        }
        else {
            jQuery('#fpd-pdf-width').parents('label:first').hide();
            jQuery('#fpd-pdf-height').parents('label:first').hide();
            jQuery('#fpd-pdf-dpi').parents('label:first').hide();
        }

    }).change();

    jQuery('[name="fpd_image_format"]').change(function() {

        if(jQuery('[name="fpd_image_format"]:checked').val() == 'svg') {
            jQuery('#fpd-pdf-width').parents('tr:first').hide();
        }
        else {
            jQuery('#fpd-pdf-width').parents('tr:first').show();
        }

    }).change();

    jQuery('input[name="fpd_scale"]').keyup(function() {

        var scale = !isNaN(this.value) && this.value.length > 0 ? this.value : 1,
            mmInPx = 3.779528;

        jQuery('#fpd-pdf-width').val(Math.round((stageWidth * scale) / mmInPx));
        jQuery('#fpd-pdf-height').val(Math.round((stageHeight * scale) / mmInPx));

    }).keyup();

    jQuery('#fpd-generate-file').click(function(evt) {

        evt.preventDefault();

        if(_checkAPI()) {

            if(jQuery('[name="fpd_output_file"]:checked').val() == 'image') {
                createImage();
            }
            else {
                fpdBlockPanel(jQuery(this).parents('.fpd-inner-panel:first'));
                createPdf();
            }

        }

    });



    //SINGLE ELEMENT IMAGES
    $customElementsList.on('click', 'li', function(evt) {

        evt.preventDefault();

        var index = $customElementsList.children('li').index(this),
            stage = fancyProductDesigner.getStage();

        fancyProductDesigner.selectView(customElements[index].element.viewIndex);
        stage.setActiveObject(customElements[index].element);

    });

    jQuery('[name="fpd_single_image_format"]').change(function() {

        if(this.value == 'jpeg') {
            jQuery('.fpd-single-element-dpi').removeClass('hidden');
        }
        else {
            jQuery('.fpd-single-element-dpi').addClass('hidden');
        }

    }).change();


    jQuery('#fpd-save-element-as-image').click(function(evt) {

        evt.preventDefault();

        if(_checkAPI()) {

            var stage = fancyProductDesigner.getStage(),
                format = jQuery('input[name="fpd_single_image_format"]:checked').val(),
                backgroundColor = format == 'jpeg' ? '#ffffff' : 'transparent',
                currentViewIndex = fancyProductDesigner.getViewIndex(),
                objects = stage.getObjects(),
                tempClippingRect = null;

            if(stage.getActiveObject()) {

                var $this = jQuery(this),
                    element = stage.getActiveObject(),
                    tempScale = element.scaleX,
                    tempWidth = stage.getWidth(),
                    tempHeight = stage.getHeight(),
                    dataObj;

                if(format == 'svg') {

                    if(element.toSVG().search('<image') != -1) {
                        fpdMessage(no_svg, 'info');
                        return false;
                    }

                }

                fancyProductDesigner.deselectElement();

                //check if origin size should be rendered
                if(jQuery('#fpd-restore-oring-size').is(':checked')) {

                    /*if(element.scaleX < 1 && element.clippingRect !== undefined) {

                        tempClippingRect = element.clippingRect;
                        var clippingScale = 1 + (1-element.scaleX);
                        fancyProductDesigner.setClippingRect(element, {
                            left: tempClippingRect.left + ((tempClippingRect.width - (tempClippingRect.width * clippingScale)) * 0.5),
                            top: tempClippingRect.top + ((tempClippingRect.height - (tempClippingRect.height * clippingScale)) * 0.5),
                            width: tempClippingRect.width * clippingScale,
                            height: tempClippingRect.height * clippingScale
                        });

                    }*/

                    element.setScaleX(1);
                    element.setScaleY(1);
                }

                stage.setBackgroundColor(backgroundColor, function() {

                    var paddingTemp = element.padding;
                    element.padding = jQuery('input[name="fpd_single_element_padding"]').val().length == 0 ? 0 : Number(jQuery('input[name="fpd_single_element_padding"]').val());

                    var clipToTemp = element.getClipTo();
                    if(clipToTemp != null) {

                        if(jQuery('#fpd-without-bounding-box').is(':checked')) {
                            element.setClipTo(null);
                            stage.renderAll();
                        }
                        else {
                            for(var i=0; i < objects.length; ++i) {

                                var object = objects[i];
                                if(object.viewIndex == currentViewIndex) {
                                    object.visible = false;
                                }

                            }

                            element.visible = true;
                        }

                    }

                    element.setCoords();

                    var source;

                    if(format == 'svg') {
                        source = element.toSVG();
                    }
                    else {
                        source = clipToTemp != null && !jQuery('#fpd-without-bounding-box').is(':checked') ? stage.toDataURL({format: format}) : element.toDataURL({format: format});
                    }

                    if(jQuery('#fpd-save-on-server').is(':checked')) {

                        fpdBlockPanel($this.parents('.fpd-inner-panel:first'));

                        if(format == 'svg') {

                            dataObj = {
                                action: 'fpd_imagefromsvg',
                                order_id: orderId,
                                item_id: currentItemId,
                                svg: source,
                                width: stage.getWidth(),
                                height: stage.getHeight(),
                                title: element.title,
                                form_key : fpd_admin_opts.checkToken
                            };
                            
                            jQuery.ajax({
                                url: fpd_admin_opts.adminAjaxUrl,
                                data: dataObj,
                                type: 'post',
                                dataType: 'json',
                                complete: function(data) {

                                    var json = data.responseJSON;
                                    if (typeof json.message != 'undefined' && json.message == 'error') {
                                        fpdMessage(fpd_admin_opts.tryAgain, 'error');
                                    } else if(data.status != 200 || json.code == 500) {
                                        fpdMessage(img_failed, 'error');
                                    }
                                    else if( json.code == 201 ) {
                                        $orderImageList.append('<li><a href="'+json.url+'" title="'+json.url+'" target="_blank">'+json.title+'.'+format+'</a></li>');
                                    }
                                    else {
                                        //prevent caching
                                        $orderImageList.find('a[title="'+json.url+'"]').attr('href', json.url+'?t='+new Date().getTime());
                                    }

                                    fpdUnblockPanel($this.parents('.fpd-inner-panel:first'));

                                }
                            });

                        }
                        else {
                            var newsource = dataURItoBlob(source);
                            var data_ajax = new FormData();                            
                            data_ajax.append('data_url', newsource, 'customproduct.png');
                            data_ajax.append('action', 'fpd_imagefromdataurl');
                            data_ajax.append('order_id', orderId);
                            data_ajax.append('item_id', currentItemId);
                            data_ajax.append('title', element.title);
                            data_ajax.append('format', format);
                            data_ajax.append('form_key', fpd_admin_opts.checkToken);
                            data_ajax.append('dpi', jQuery('[name="fpd_single_element_dpi"]').val().length == 0 ? 72 : jQuery('[name="fpd_single_element_dpi"]').val());
                            
                            dataObj = data_ajax;
                            jQuery.ajax({
                                url: fpd_admin_opts.adminAjaxUrl,
                                data: dataObj,
                                type: 'post',
                                processData: false,
                                contentType: false,
                                dataType: 'json',
                                complete: function(data) {

                                    var json = data.responseJSON;
                                    if (typeof json.message != 'undefined' && json.message == 'error') {
                                        fpdMessage(fpd_admin_opts.tryAgain, 'error');
                                    } else if(data.status != 200 || json.code == 500) {
                                        fpdMessage(img_failed, 'error');
                                    }
                                    else if( json.code == 201 ) {
                                        $orderImageList.append('<li><a href="'+json.url+'" title="'+json.url+'" target="_blank">'+json.title+'.'+format+'</a></li>');
                                    }
                                    else {
                                        //prevent caching
                                        $orderImageList.find('a[title="'+json.url+'"]').attr('href', json.url+'?t='+new Date().getTime());
                                    }

                                    fpdUnblockPanel($this.parents('.fpd-inner-panel:first'));

                                }
                            });
                        }

                        

                    }
                    else { //dont save it on server

                        var popup = window.open('','_blank');
                        if(!_popupBlockerEnabled(popup)) {

                            popup.document.title = element.title;

                            if(format == 'svg') {
                                source = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="'+stage.getWidth()+'" height="'+stage.getHeight()+'" xml:space="preserve">'+element.toSVG()+'</svg>';
                                jQuery(popup.document.body).append(source);
                            }
                            else {
                                jQuery(popup.document.body).append('<img src="'+source+'" title="Product" />');

                            }

                        }

                    }

                    for(var i=0; i < objects.length; ++i) {

                        var object = objects[i];
                        if(object.viewIndex == currentViewIndex) {
                            object.visible = true;
                        }

                    }

                    element.set({scaleX: tempScale, scaleY: tempScale, padding: paddingTemp})
                    .setClipTo(clipToTemp)
                    .setCoords();

                    if(tempClippingRect !== null) {
                        //fancyProductDesigner.setClippingRect(element, tempClippingRect);
                    }

                    stage.setBackgroundColor('transparent')
                    .setDimensions({width: tempWidth, height: tempHeight})
                    .renderAll();

                });

            }
            else {
                fpdMessage(no_element, 'info');
            }
        }

    });
	
	/*----- SETTINGS ----------*/

		//hide labels tab when "use labels settings" is disabled
		$('#fpd_use_label_settings').change(function() {

			$('#radykal-nav-tab--labels').toggle($(this).is(':checked'));

		}).change();

		//bounding box control
		$('[name="bounding_box_control"]').change(function() {

			var $this = $(this),
				$tbody = $this.parents('tbody');

			$tbody.find('.custom-bb, .target-bb').hide().addClass('no-serialization');
			if(this.value != '') {
				$tbody.find('.'+$this.find(":selected").data('class')).show().removeClass('no-serialization');
			}

		});
		var openModal = function( $modalWrapper ) {

			jQuery('body').addClass('fpd-modal-open');
			$modalWrapper.addClass('fpd-modal-visible');

		};

		var closeModal = function( $modalWrapper ) {

			$modalWrapper.removeClass('fpd-modal-visible');
			jQuery('body').removeClass('fpd-modal-open');
			if(jQuery().select2) {
				$modalWrapper.find('.fpd-select2').each(function() {
					jQuery(this).select2("close");
				});
			}
			fpdResetForm($modalWrapper);

		};

		var fpdMessage = function(text, type) {

			jQuery('.fpd-message-box').remove();

			var $messageBox = jQuery('body').append('<div class="fpd-message-box fpd-'+type+'"><p>'+text+'</p></div>').children('.fpd-message-box').hide();
			$messageBox.css('margin-left', -$messageBox.width() * 0.5).fadeIn(300);

			$messageBox.delay(6000).fadeOut(200, function() {
				jQuery(this).remove();
			});

		};

		var fpdUpdateTooltip = function() {

			jQuery('.fpd-admin-tooltip').each(function(i, tooltip) {

				var $tooltip = jQuery(tooltip);
				if($tooltip.hasClass('tooltipstered')) {
					$tooltip.tooltipster('reposition');
				}
				else {
					$tooltip.tooltipster({
						offsetY: 0,
						theme: '.fpd-admin-tooltip-theme'
					});
				}

			});

		};

		var fpdParseJson = function(file) {

			try {
			  json = JSON.parse(file);
			} catch (exception) {
			  json = null;
			}

			if(json == null) {
				fpdMessage(fpd_fancy_products_opts.noJSON, 'error');
				return false;
			}
			else {
				return json;
			}

		};

		var fpdFillFormWithObject = function(objectString, $form) {

			try {
				var settingsObject = JSON.parse(objectString);


				for(var prop in settingsObject) {
					if(settingsObject.hasOwnProperty(prop)) {

						var value = settingsObject[prop],
							$formElement = $form.find('[name="'+prop+'"]');


						if($formElement.is('input[type="radio"]') || $formElement.is('input[type="checkbox"]')) {
							$formElement.filter('[value="'+value+'"]').prop('checked', true);
						}
						else {
							$formElement.val(value);
						}

					}
				}
			}
			catch(e) {
			  // nothing
			}

		};

		var fpdResetForm = function($form) {

			$form.find('[type="text"], [type="number"], textarea, select').val('');
			$form.find('[type="checkbox"], option').removeAttr('checked').removeAttr('selected');

		};

		var fpdSerializeObject = function(fields) {
			var o = {};
			var a = fields.serializeArray();
			jQuery.each(a, function() {
				if (o[this.name] !== undefined) {
					if (!o[this.name].push) {
						o[this.name] = [o[this.name]];
					}
					if(this.value) {
						o[this.name].push(this.value || '');
					}

				} else {
					if(this.value) {
						o[this.name] = this.value || '';
					}
				}
			});
			return o;
		};

		var fpdCheckTitleInput = function(title, errorMessage) {

			if(title == null) {
				return false;
			}
			else if(title.length == 0) {
				fpdMessage(errorMessage+'!', 'error');
				return false;
			}

			return title;

		}

		//add new product via ajax
		var fpdAddProduct = function(callback) {

			var title = prompt(fpd_admin_opts.enterTitlePrompt+':', "");

			if(title == null) {
				callback(false);
				return false;
			}
			else if(title.length == 0) {
				fpdMessage(fpd_admin_opts.enterTitlePrompt+'!', 'error');
				callback(false);
				return false;
			}

			jQuery.ajax({
				url: fpd_admin_opts.adminAjaxUrl,
				data: {
					action: 'fpd_newproduct',
					form_key : fpd_admin_opts.checkToken,
					title: title
				},
				type: 'post',
				dataType: 'json',
				success: function(data) {

					if(data !== undefined || data.id !== undefined) {

						fpdMessage(data.message, data.id ? 'success' : 'error');

						if(callback !== undefined) {
							callback(data);
						}

						fpdUpdateTooltip();

					}

				}
			});

		};

		//add views to a product via ajax
		var fpdAddViews = function(productId, views, addToLibrary, viewAdded, complete) {

			var keys = Object.keys(views),
				viewCount = 0;

			function _addView(view) {

				jQuery.ajax({
					url: fpd_admin_opts.adminAjaxUrl,
					data: {
						action: 'fpd_newview',
						form_key : fpd_admin_opts.checkToken,
						title: view.title,
						elements: JSON.stringify(view.elements),
						thumbnail: view.thumbnail,
						thumbnail_name: view.thumbnail_name ? view.thumbnail_name : view.title,
						add_images_to_library: addToLibrary ? 1 : 0,
						product_id: productId
					},
					type: 'post',
					dataType: 'json',
					success: function(data) {

						viewCount++;

						if(data !== 0) {
							if(viewAdded !== undefined) {
								viewAdded(data);
							}
						}

						if(viewCount < keys.length) {
							_addView(views[keys[viewCount]]);
						}
						else {

							if(complete !== undefined) {
								complete();
							}

							fpdUpdateTooltip();

						}

					},
					error: function() {
						complete(false);
						fpdAjaxError();
					}
				});

			}

			if(keys.length > 0) {
				_addView(views[keys[0]]);
			}
			else {
				if(complete !== undefined) {
					complete();
				}
			}

		};

		var fpdAjaxError = function() {

			fpdMessage(fpd_admin_opts.tryAgain, 'error');

		};

		var fpdBlockPanel = function($panel) {

			$panel.find('.fpd-ui-blocker').show();

		};

		var fpdUnblockPanel = function($panel) {

			$panel.find('.fpd-ui-blocker').hide();

		};


		//update the form fields
		var fpdSetDesignFormFields = function(paramsInput, thumbnailInput) {

			var $designThumbnail = jQuery('#fpd-design-modalbox'), //thumbnail img-element
				$modalWrapper = $designThumbnail.parents('.fpd-modal-wrapper:first');

			if(thumbnailInput) {
				jQuery('#fpd-set-design-thumbnail-wrapper').show();
				$designThumbnail.attr('src', thumbnailInput.val());
				thumbnailInput.val().length > 0 ? $designThumbnail.show() : $designThumbnail.hide();

			}
			else {
				jQuery('#fpd-set-design-thumbnail-wrapper').hide();
			}

			var parameter_str = paramsInput.val().length > 0 ? paramsInput.val() : 'enabled=0&x=0&y=0&z=-1&scale=1&price=0&replace=&bounding_box_control=0&boundingBoxClipping=0';

			jQuery.each(parameter_str.split('&'), function (index, elem) {
				var vals = elem.split('='),
					$targetElement = $modalWrapper.find("form [name='" + vals[0] + "']");

				if($targetElement.is(':checkbox')) {
					$targetElement.prop('checked', vals[1] == 1);
				}
				else {
					$targetElement.val(unescape(vals[1]));
				}

			});

			$modalWrapper.find('input[name="enabled"],[name="bounding_box_control"]').change();

			openModal($modalWrapper);

		};
		
	var mediaUploader = null;

	fpdUpdateTooltip();

	/*----- MODAL ----------*/

	$('body').on('click', '.fpd-close-modal', function(evt) {
		closeModal($(this).parents('.fpd-modal-wrapper'));
		evt.preventDefault();
	});

	//Tabs in Modal
	var $modalWrapper = $('.fpd-modal-wrapper');
	$modalWrapper.find(".fpd-tabs-content").find("[id^='tab']").hide(); // Hide all content
	$modalWrapper.find(".fpd-tabs li:first").attr("id","current"); // Activate the first tab
	$modalWrapper.find(".fpd-tabs-content #tab1").fadeIn(); // Show first tab's content

	$modalWrapper.find('.fpd-tabs a').click(function(evt) {

		evt.preventDefault();

		if(jQuery().select2) {
			$modalWrapper.find('.fpd-select2').each(function() {
				jQuery(this).select2("close");
			});
		}

		if ($(this).closest("li").attr("id") == "current"){ //detection for current tab
			return;
		}
		else{
			$modalWrapper.find(".fpd-tabs-content").find("[id^='tab']").hide(); // Hide all content
			$modalWrapper.find(".fpd-tabs li").attr("id",""); //Reset id's
			$(this).parent().attr("id","current"); // Activate this
			$('#' + $(this).attr('name')).fadeIn(); // Show content for the current tab
		}

	});

    function createImage() {

        var format = jQuery('input[name="fpd_image_format"]:checked').val(),
            data;

        if(format == 'svg') {
            data = fancyProductDesigner.getViewsSVG();
        }
        else {
            var backgroundColor = format == 'jpeg' ? '#ffffff' : 'transparent',
                multiplier = jQuery('input[name="fpd_scale"]').val().length == 0 ? 1 : Number(jQuery('input[name="fpd_scale"]').val());

            data = fancyProductDesigner.getViewsDataURL(format, backgroundColor, multiplier);
        }

        if(jQuery('[name="fpd_export_views"]:checked').val() == 'current') {
            var requestedIndex = data[fancyProductDesigner.getViewIndex()];
            data = [];
            data.push(requestedIndex);
        }

        var popup = window.open('','_blank');
        if(!_popupBlockerEnabled(popup)) {
            popup.document.title = orderId;
            for(var i=0; i < data.length; ++i) {
                if(format == 'svg') {
                    jQuery(popup.document.body).append(data[i]);
                }
                else {
                    jQuery(popup.document.body).append('<img src="'+data[i]+'" title="View'+i+'" />');
                }

            }

        }

    };
    
    function dataURItoBlob(dataURI) {
        // convert base64/URLEncoded data component to raw binary data held in a string
        var byteString;
        if (dataURI.split(',')[0].indexOf('base64') >= 0)
            byteString = atob(dataURI.split(',')[1]);
        else
            byteString = unescape(dataURI.split(',')[1]);
        // separate out the mime component
        var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
        // write the bytes of the string to a typed array
        var ia = new Uint8Array(byteString.length);
        for (var i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }
        return new Blob([ia], {type:mimeString});
    }

    function createPdf() {

        var $panel = jQuery('#fpd-generate-file').parents('.fpd-inner-panel:first');

        if(jQuery('#fpd-pdf-width').val() == '') {
            fpdMessage(no_width, 'error');
            return false;
        }
        else if(jQuery('#fpd-pdf-height').val() == '') {
            fpdMessage(no_height, 'error');
            return false;
        }

        fpdBlockPanel($panel);

        var format = jQuery('input[name="fpd_image_format"]:checked').val(),
            backgroundColor = format == 'jpeg' ? '#ffffff' : 'transparent',
            data;

        if(format == 'svg') {
            data = fancyProductDesigner.getViewsSVG();
        }
        else {
            var multiplier = jQuery('input[name="fpd_scale"]').val().length == 0 ? 1 : Number(jQuery('input[name="fpd_scale"]').val());
            data = fancyProductDesigner.getViewsDataURL(format, backgroundColor, multiplier);
            var newdata = [];
            $.each(data, function(index, value) {
                newdata.push(dataURItoBlob(value));
            });
            data = newdata;
        }
        
        if(jQuery('[name="fpd_export_views"]:checked').val() == 'current') {            
            var requestedIndex = data[fancyProductDesigner.getViewIndex()];
            data = [];
            data.push(requestedIndex);
        }
        var data_ajax = new FormData();
        if(format == 'svg') {            
            data_ajax.append('data_strings', data);
        } else {
            $.each(data, function(index, value) {
                data_ajax.append('data_strings'+index+'[]', value, 'customproduct'+index+'.png');
            });
        }

        data_ajax.append('action', 'fpd_pdffromdataurl');
        data_ajax.append('order_id', orderId);
        data_ajax.append('item_id', currentItemId);        
        data_ajax.append('format', format);
        data_ajax.append('form_key', fpd_admin_opts.checkToken);
        data_ajax.append('width', jQuery('#fpd-pdf-width').val());
        data_ajax.append('height', jQuery('#fpd-pdf-height').val());
        data_ajax.append('image_format', jQuery('input[name="fpd_image_format"]:checked').val());        
        data_ajax.append('orientation', stageWidth > stageHeight ? 'L' : 'P');
        data_ajax.append('dpi', jQuery('#fpd-pdf-dpi').val().length == 0 ? 300 : jQuery('#fpd-pdf-dpi').val());

        jQuery.ajax({
            url: fpd_admin_opts.adminAjaxUrl,
            data: data_ajax,
            processData: false,
            contentType: false,
            type: 'post',
            dataType: 'json',
            complete: function(data) {
                if (typeof data.responseJSON.message != 'undefined' && data.responseJSON.message == 'error') {
                    fpdMessage(fpd_admin_opts.tryAgain, 'error');
                } else if(data == undefined || data.status != 200) {

                    var message = '';
                    if(data.responseJSON && data.responseJSON.message) {
                        message += data.responseJSON.message;
                    }
                    message += '.\n';
                    message += pdf_createion_failed;
                    fpdMessage(message, 'error');

                }
                else {
                    var json = data.responseJSON;
                    if(json !== undefined) {
                        window.open(json.url, '_blank');
                    }
                    else {
                        fpdMessage(jsn_not_passed, 'error');
                    }
                }

                fpdUnblockPanel($panel);

            }
        });

    };

    function _checkAPI() {

        if(fancyProductDesigner.getStage().getObjects().length > 0 && isReady) {
            return true;
        }
        else {
            fpdMessage(no_fancy, 'error');
            return false;
        }

    };

    function _popupBlockerEnabled(popup) {

        if (popup == null || typeof(popup)=='undefined') {
            fpdMessage(popu_up_b, 'info');
            return true;
        }
        else {
            return false;
        }

    }

});


function fpdLoadOrder(order) {

    if(typeof order !== 'object') { return false; }

    loadingProduct = true;
    $orderImageList.empty();
    fancyProductDesigner.clear();

    stageWidth = (order[0].options === undefined || order[0].options.width === undefined) ? stageWidth : order[0].options.width;
    stageHeight = (order[0].options === undefined || order[0].options.stageHeight === undefined) ? stageHeight : order[0].options.stageHeight;

    jQuery('#fpd-stage-width').attr('placeholder', stageWidth);
    jQuery('#fpd-stage-height').attr('placeholder', stageHeight);
    jQuery('input[name="fpd_scale"]').keyup();

    fancyProductDesigner.loadProduct(order);

    jQuery.ajax({

        url: fpd_admin_opts.adminAjaxUrl,
        data: {
            action: 'fpd_loadorderitemimages',
            order_id: orderId,
            item_id: currentItemId,
            form_key : fpd_admin_opts.checkToken
        },
        type: 'post',
        dataType: 'json',
        success: function(data) {

            if(data == undefined || data.code == 500) {

                fpdMessage(cound_not, 'info');

            }
            //append order item images to list
            else if( data.code == 200 ) {

                for (var i=0; i < data.images.length; ++i) {
                    var title = data.images[i].substr(data.images[i].lastIndexOf('/')+1);
                    $orderImageList.append('<li><a href="'+data.images[i]+'" title="'+data.images[i]+'" target="_blank" >'+title+'</a></li>');
                }

            }

        }

    });

};
});