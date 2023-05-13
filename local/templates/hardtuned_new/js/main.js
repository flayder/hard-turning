function addingEcommerce($product) {
	dataLayer.push({
	    "ecommerce": {
	        "add": {
	            "products": [
	              	$product  
	            ]
	        }
	    }
	})
}

window.priceFormat = function (price) {
	price = ""+price;
	if(price.length > 3) {
		var b = price.substr(0, parseInt(price.length-3));
		var e = price.substr(-3);
		return b + ' ' + e;
	} else {
		return price;
	}
}

window.checkSize = function ($modal) {
	$modal.find('.wrap-content').css('maxHeight', $(window).height());
	$modal.css({
		marginTop: -($modal.outerHeight() / 2),
		marginLeft: -($modal.outerWidth() / 2),
	});
}

$(document).ready(function(){
	$('.bx-ui-sls-fake').attr('placeholder', 'Напишите город получения');
	// $(document).on('mouseover', '.accordion > li', function(){
	// 	var $this = $(this);
	// 	var $modal = $('.modal_bg');
	// 	if($this.find('.wrap-menu').length) {
	// 		$modal.fadeIn();
	// 		$('body').addClass('hover-menu');
	// 	}
	// }).on('mouseout', '.accordion > li', function(){
	// 	var $this = $(this);
	// 	var $modal = $('.modal_bg');
	// 	if($this.find('.wrap-menu').length) {
	// 		$('body').removeClass('hover-menu');
	// 		$modal.fadeOut();
	// 	}
	// });
	//$(document).on('click', '[data-ajax-id]', function(){
//
    //    var targetContainer = $('.cat-block'),
    //    	ajaxId = $(this).attr('data-ajax-id');
    //        url =  $(this).attr('data-url'),
    //        currentPage = $(this).attr('data-current-page');
//
    //        if(window['globalPageCurrent' + ajaxId] === undefined) window['globalPageCurrent' + ajaxId] = 0;
//
    //        if(new String(url).indexOf('?') !== -1) {
    //        	url += '&PAGEN_1=' + (parseInt(currentPage) + 1);
    //        } else {
    //        	url += '?PAGEN_1=' + (parseInt(currentPage) + 1);
    //        }
//
    //        
//
    //    if (url !== undefined &&  window['globalPageCurrent' + ajaxId] < currentPage) {
    //    	//console.log(url);
    //    	window['globalPageCurrent' + ajaxId] = currentPage;
    //        $.ajax({
    //            type: 'GET',
    //            url: url,
    //            dataType: 'html',
    //            success: function(data){
//
    //                //  Удаляем старую навигацию
    //                $('.load_more'+ajaxId).remove();
//
    //                var elements = $(data).find('.cat-block').attr("class", ""),  //  Ищем элементы
    //                    pagination = $(data).find('.load_more'+ajaxId);//  Ищем навигацию
//
    //                targetContainer.append(elements);   //  Добавляем посты в конец контейнера
    //                targetContainer.append(pagination); //  добавляем навигацию следом
//
    //            }
    //        })
    //    }
//
    //});
    $(document).on('click', '.load_more', function(){
    	if($('.load_more').length > 0) {
     		var targetContainer = $('.cat-block'),          //  Контейнер, в котором хранятся элементы
     		    url =  $('.load_more').attr('data-url');    //  URL, из которого будем брать элементы
     		    $('.load_more').remove();
     		if (url !== undefined) {
     		    $.ajax({
     		        type: 'GET',
     		        url: url,
     		        dataType: 'html',
     		        success: function(data){

     		            //  Удаляем старую навигацию

     		            var elements = $(data).find('.product-block'),  //  Ищем элементы
     		                pagination = $(data).find('.load_more');//  Ищем навигацию

     		            targetContainer.append(elements);   //  Добавляем посты в конец контейнера
     		            targetContainer.append(pagination); //  добавляем навигацию следом

     		        }
     		    })
     		}
     	}
    });

	$(document).on('scroll', function(){
		var $this = $(this);
		var $scroll = $('.load_more');
		if($scroll.length)
			if($this.scrollTop() >= $('.cat-block').offset().top + 200) $scroll.click();
	});

	$(document).on('click', '.list-tab-wr .item-tab', function() {
		const $this = $(this)
		$this.parent().find('.item-tab').removeClass('active')
		$this.addClass('active')
	})

	$(document).on('click', '.lk_block-title', function(){
		var $this = $(this);
		$this.next('.lk_block-wrap').slideToggle();
		var firstClick = true;
		$(document).bind('click.catMenu', function(){
			if(!firstClick) {
				$this.next('.lk_block-wrap').slideUp();
				$(document).unbind('click.catMenu');
			}
		});
		firstClick = false;
	});
	function reloadModalBasket() {
		$.ajax({
		    url: '/ajax/reloadBasket.php',
		    data: {},
		    contentType: false,
		    processData: false,
		    dataType: 'json',
		    type: 'POST',
		    success: function(resp){
		    	$form = $('#buy_order form .wr');
		    	$form.empty();
		    	$products = '';
		    	if(!$.isEmptyObject(resp)) {
		    		for(var i in resp) {
		    			try {
		    				var pict = (resp[i].PRODUCT_INFO.PREVIEW_PICTURE)?resp[i].PRODUCT_INFO.PREVIEW_PICTURE:'';
		    				$products = '<div class="basket_produсt">';
								$products += '<div class="img">';
									$products += '<a href="'+resp[i].PRODUCT_INFO.DETAIL_PAGE_URL+'">';
										if(pict != '') $products += '<img src="'+pict+'" alt="img"></div>';
									$products += '</a>';
								$products += '<div class="middle">';
									$products += '<div class="left">';
										$products += '<div class="art">';
											$products += 'Арт: ';
											$products += '<span>'+resp[i].PRODUCT_INFO.PROPS.VALUE+'</span>';
										$products += '</div>';
										$products += '<div class="name"><a href="'+resp[i].PRODUCT_INFO.DETAIL_PAGE_URL+'">'+resp[i].PRODUCT_INFO.NAME+'</a></div>';
									$products += '</div>';
									$products += '<div class="bl-basket">';
										$products += '<div class="price">';
											$products += '<span>'+priceFormat(resp[i].PRICE)+'</span>';
											$products += ' руб.';
										$products += '</div>';
										$products += '<div class="counter">';
											$products += '<span class="btn-counter minus" data-add-basket="'+resp[i].PRODUCT_ID+'">';
												$products += '<i class="fas fa-minus"></i>';
											$products += '</span>';
											$products += '<input type="number" class="value" value="'+resp[i].QUANTITY+'">';
											$products += '<span class="btn-counter plus" data-add-basket="'+resp[i].ID+'">';
												$products += '<i class="fas fa-plus"></i>';
											$products += '</span>';
										$products += '</div>';
									$products += '</div>';
									$products += '<div class="btn-c">';
										$products += '<a href="javascript:void(0)" data-ecommerce=\''+JSON.stringify({
											"id": resp[i].PRODUCT_ID,
												"name": resp[i].PRODUCT_INFO.NAME,
												"category": resp[i].PRODUCT_INFO.SECTION_NAME,
												"quantity":resp[i].QUANTITY
											})+'\' class="cansel modal-cansel">';
											$products += '<i class="fas fa-times"></i>';
										$products += '</a>';
									$products += '</div>';
								$products += '</div>';
							$products += '</div>';
							$form.append($products);
		    			} catch(e) {}
					}
					$form.parents('#buy_order').find('.total-price span, .total_count span').text(priceFormat(resp.TOTAL_PRICE));
					BX.onCustomEvent('OnBasketChange');
					if($this.hasClass('btn-product')) {
						$this.attr('data-add-basket', '');
						$this.addClass('active').html('<span class="icon"></span>Добавлено');
					}
					var $mod = $('.modal_bg');
					var $modal = $('#buy_order');
					if($modal.css('display') != 'block') {
						checkSize($modal);
						$modal.fadeIn();
						$mod.fadeIn();
						var $firstClick = true;
						$(document).bind('click.MyClick', function(e){
							if(!$firstClick && $(e.target).closest('.modal_wrap').length == 0
								|| $(e.target).closest('.close').length == 1
								|| $(e.target).closest($('#buy_order .btn-f.gr')).length == 1) {
								$modal.fadeOut();
								$mod.fadeOut();
								$(document).unbind('click.MyClick');
							}
							$firstClick = false;
						});
					}
				}
		    }
		});
	}
	
	
	$(document).on('click', '.counter .minus', function () {
        var $input = $(this).parent().find('input');
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
    });
    $(document).on('click', '.counter .plus', function () {
        var $input = $(this).parent().find('input');
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        return false;
    });
    $(document).on('change', '.price-panel .value', function (e) {
        var $this = $(this);
        $('.panel-b .btn-c-lilac').attr('data-quantity', ($this.val() > 0)?$this.val():1);
    });
    $(document).on('click', '[data-buy1click-product-id]', function(){
    	var $this = $(this);
    	var $modal = $this.data('modal');
    	var $id = $this.data('buy1click-product-id');
    	$modal = $($modal);
    	$modal.find('#metrica_data').val($this.attr('data-byuing1click'))
    	$modal.find('#product_hidden_id').val($id);
    	$modal.find('#drawing').val($('#SETTING').prop('checked') ? "Y" : "N");
    	$modal.find('.small').text($('h1').text());
    });
    $(document).on('click', '[data-remove]', function(e){
    	var $this = $(this);
    	var $products_id = $this.data('remove');
    	var $prod = $this.attr('data-ecommerce')
    	var $val = $this.parents('.basket_produсt:eq(0)').find('.value').val()
    	if($prod) {
    		$prod = JSON.parse($prod)
    		$prod.quantity = $val
    	}
    	
    	$data = new FormData;
    	$data.append('product_id', $products_id);
    	$.ajax({
		   url: '/ajax/removeProduct.php',
		   data: $data,
		   contentType: false,
		   processData: false,
		   type: 'POST',
		   success: function(resp){
		   		if(resp == 'Y') {
		   			try {
		   				if($this && $this.hasClass("modal-cansel"))
		   				reloadModalBasket()
		   				else
		   					$this.parents('.basket_produсt:eq(0)').fadeOut(function(){
		   						$(this).remove();
		   						checkSize($('#buy_order'));
		   						window.location.reload();
		   					});
		   			} catch(e){}
		   		}
		   }
		});
		dataLayer.push({
		    "ecommerce": {
		        "remove": {
		            "products": [
		                $prod
		            ]
		        }
		    }
		})
    	e.preventDefault();
    });
    $(document).on('submit', '#buy_one_click form', function(e){
    	var $this = $(this);
    	var $products_id = $this.find('#product_hidden_id').val();
    	var $name = $this.find('input[name="name"]').val();
    	var $phone = $this.find('input[name="phone"]').val();
    	var $email = $this.find('input[name="email"]').val();
    	var $drawing = $this.find('#drawing').val();
    	let $json;

    	try {
    		$json = JSON.parse($this.find('#metrica_data').val())
    	} catch(e){}

    	if($products_id == '') {
    		alert('Некорректный ID продукта');
    		return;
    	}

    	$data = new FormData;
    	$data.append('ID', $products_id);
    	$data.append('name', $name);
    	$data.append('phone', $phone);
    	$data.append('email', $email);
    	$data.append('drawing', $drawing);

    	$.ajax({
		    url: '/ajax/buy1click.php',
		    data: $data,
		    contentType: false,
		    processData: false,
		    type: 'POST',
		    success: function(resp){
		    	$this.find('.block-e').empty();
		        if(resp.DONE != 'Y' && !$.isEmptyObject(resp.ERRORS)) {
		        	for(var i in resp.ERRORS) {
		        		$this.find('.block-e').append('<div class="error">'+resp.ERRORS[i]+'</div>');
		        	}
		        } else if(resp.DONE == 'Y') {
		        	if($json)
		        		dataLayer.push({
						    "ecommerce": {
						        "purchase": {
						        	"actionField": {
									    "id" : new Date().getTime(),
									    "goal_id": 52896730
									},
						            "products": [
						              	$json
						            ]
						        }
						    }
						})
		        	$this.parents('.modal_wrap:eq(0)').find('.wrap-content:eq(0)').hide();
		        	$this.parents('.modal_wrap:eq(0)').find('.wrap-content:eq(1)').fadeIn();
		        	checkSize($('#buy_one_click'));
		        	dataLayer.push({'event': 'klik','transactionId': '52896730'});
		        }
		    }
		});
    	return false;
    });

    $(document).on('submit', '#d-form form', function(e){
    	var $this = $(this);
    	var error = false;
    	$this.find('.req-r').remove();
    	$this.find('.req').removeClass('req');

    	if($this.find('#check').prop('checked') == false) {
    		error = true;
    		alert('Вы не согласились с политикой конфиденциальности');
    	}

    	if($this.find('[name="cooperation"]').val() == 'Выберите вариант') {
    		$this.find('[name="cooperation"]').parents('.input:eq(0)').addClass('req').append('<span class="req-r">поле не заполнено</span>');
    		error = true;
    	}

    	if($this.find('[name="text"]').val().length == 0) {
    		$this.find('[name="text"]').parents('.input:eq(0)').addClass('req').append('<span class="req-r">поле не заполнено</span>');
    		error = true;
    	}

    	if(!error) {
    		var $data = new FormData($this[0]);

    		$.ajax({
			    url: '/ajax/cooperation.php',
			    data: $data,
			    contentType: false,
			    processData: false,
		    	type: 'POST',
			    success: function(resp){
			    	if(resp.DONE == 'Y') {
			    		$this.empty().append('<h1 class="success-mess">Ваша заявка принята на обработку, мы в ближайшее время свяжемся с вами</h1>');
			    	}
			    }
			});
    	}
    	return false;
    });

    $(document).on('submit', '.tracking_block form', function(){
    	var $this = $(this);
    	var $data = new FormData();
    	$data.append('order', $this.find('input').val());
    	$.ajax({
		    url: '/ajax/check_order.php',
		    data: $data,
		    contentType: false,
		    processData: false,
		    dataType: 'json',
		    type: 'POST',
		    success: function(resp){
		    	if(resp.order.STATUS) {
		    		$this.html('<div class="status">Статус заказа: <span>'+resp.order.STATUS.NAME+'</span></div>');
		    	} else {
		    		$this.prev('.err').html('<span>Неверные данные</span></div>');
		    	}
		    }
		});
		return false;
    });

    $(document).on('keyup', '.search_input input[name="q"]', function(){
    	var $this = $(this);
    	var $data = new FormData();
    	$data.append('q', $this.val());
    	$.ajax({
		    url: '/ajax/search.php',
		    data: $data,
		    contentType: false,
		    processData: false,
		    dataType: 'json',
		    type: 'POST',
		    success: function(resp){
		    	$('.hint').remove();
		    	$('body').append('<div class="hint"></div>');
		    	var $hint = $('.hint');
		    	$hint.addClass('loading').css({
		    		width: $this.outerWidth(),
		    		left: $this.offset().left,
		    		top: $this.offset().top + $this.outerHeight()
		    	});
		    	setTimeout(function(){
		    		$hint.removeClass('loading');
		    		if(resp.results.length > 0) {
		    			var $str = "<ul>";
		    			for(var i in resp.results) {
		    				$str += "<li><a href='"+resp.results[i].DETAIL_PAGE_URL+"'><span class='image'><img src='"+resp.results[i].PICTURE+"'></span><span class='wrap'><span class='articul'>"+resp.results[i].ID+"</span><span class='name'>"+resp.results[i].NAME+"</span></span></a></li>";
		    			}
		    			if(resp.results.length == 5) $str += "<li><a href='/search/index.php?q="+$this.val()+"' class='all'>Посмотреть все результаты</a></li>";
		    			$str += "</ul>";
		    			$hint.html($str);
		    		} else {
		    			var $str = "<ul>";
		    			$str += "<li><a href='javascript:;' class='error'>По вашему запросу не найдено совпадений</a></li>";
		    			$str += "</ul>";
		    			$hint.html($str);
		    		}
		    		var $firstClick = true;
		    		$(document).bind('click.search', function(){
		    			$hint.remove();
		    			$(document).unbind('click.search');
		    		});
		    	}, 500);
		    }
		});
		return false;
    });

    $('.search_input input').each(function(){
    	var theaterForSearchBox = new TheaterJS();
		theaterForSearchBox
		.describe("SearchBox", .8, "#"+$(this).attr('id'))
		.write("SearchBox:Поиск по названию детали или машине").write({
			name: 'wait',
			args: [2000]
		})
		.write("SearchBox:Артикул товара").write({
			name: 'wait',
			args: [2000]
		})
		.write(function () {
			theaterForSearchBox.play(true);
		});
	});

	$(document).on('click', '[data-add-basket]', function(){
		var $this = $(this);
		var $product_id = $this.data("add-basket");
		var $quantity = ($this.hasClass('btn-counter'))?$this.parent().find('.value').val():$this.data("quantity");
		var $data = new FormData;
		var modifications = [];
		if($product_id == '') return;
		$('[data-modification-id]').each(function(){
			if($(this).is(':checked')) {
				modifications.push($(this).data('modification-id'));
			}
			$(this).parents('.input.radio:eq(0)').remove();
		});
		$data.append('modifications', JSON.stringify(modifications));
		$data.append('product_id', $product_id);
		$data.append('quantity', ($quantity>0)?$quantity:1);
		$data.append('drawing', $('#SETTING').prop('checked') ? "Y" : "N");
		$.ajax({
		    url: '/ajax/addBasket.php',
		    data: $data,
		    contentType: false,
		    processData: false,
		    //dataType: 'json',
		    type: 'POST',
		    success: function(resp){
		    	console.log(resp);
		    	$form = $('#buy_order .wr');
		    	$form.empty();
		    	$products = '';
		    	if(!$.isEmptyObject(resp)) {
		    		for(var i in resp) {
		    			try {
		    				var pict = (resp[i].PRODUCT_INFO.PREVIEW_PICTURE)?resp[i].PRODUCT_INFO.PREVIEW_PICTURE:'';
		    				$products = '<div class="basket_produсt" id="modal-basket-item'+resp[i].PRODUCT_ID+'">';
								$products += '<div class="img">';
									$products += '<a href="'+resp[i].PRODUCT_INFO.DETAIL_PAGE_URL+'">';
										if(pict != '') $products += '<img src="'+pict+'" alt="img"></div>';
									$products += '</a>';
								$products += '<div class="middle">';
									$products += '<div class="left">';
										$products += '<div class="art">';
											$products += 'Арт: ';
											$products += '<span>'+resp[i].PRODUCT_INFO.PROPS.VALUE+'</span>';
										$products += '</div>';
										$products += '<div class="name"><a href="'+resp[i].PRODUCT_INFO.DETAIL_PAGE_URL+'">'+resp[i].PRODUCT_INFO.NAME+'</a></div>';
									$products += '</div>';
									$products += '<div class="bl-basket">';
										$products += '<div class="price">';
											$products += '<span>'+priceFormat(resp[i].PRICE)+'</span>';
											$products += ' руб.';
										$products += '</div>';
										$products += '<div class="counter">';
											$products += '<span class="btn-counter minus" data-add-basket="'+resp[i].PRODUCT_ID+'">';
												$products += '<i class="fas fa-minus"></i>';
											$products += '</span>';
											$products += '<input type="number" class="value" value="'+resp[i].QUANTITY+'">';
											$products += '<span class="btn-counter plus" data-add-basket="'+resp[i].PRODUCT_ID+'">';
												$products += '<i class="fas fa-plus"></i>';
											$products += '</span>';
										$products += '</div>';
									$products += '</div>';
									$products += '<div class="btn-c">';
										$products += '<a href="javascript:void(0)" data-remove="'+resp[i].ID+'" data-ecommerce=\''+JSON.stringify({
											"id": resp[i].PRODUCT_ID,
											"name": resp[i].PRODUCT_INFO.NAME,
											"category": resp[i].PRODUCT_INFO.SECTION_NAME,
											"quantity":resp[i].QUANTITY
										})+'\' class="cansel modal-cansel">';
											$products += '<i class="fas fa-times"></i>';
										$products += '</a>';
									$products += '</div>';
								$products += '</div>';
							$products += '</div>';
							$form.prepend($products);

		    			} catch(e) {}
					}
					$form.parents('#buy_order').find('.total-price span').text(priceFormat(resp.TOTAL_PRICE));
					BX.onCustomEvent('OnBasketChange');
					if($this.hasClass('btn-product') || $this.hasClass('btn-c-lilac')) {
						$this.attr('data-add-basket', '');
						$this.addClass('active').html('<span class="icon"></span>Добавлено');
						//$this.attr('onClick', "dataLayer.push({'event': 'klik','transactionId': '52896730'});");
					}
					if(window.location.href.indexOf('cart') === -1) {
						var $mod = $('.modal_bg');
						var $modal = $('#buy_order');
						if($modal.css('display') != 'block') {
							checkSize($modal);
							$modal.fadeIn();
							$mod.fadeIn();
							$('[data-modification-id]').remove();
							var $firstClick = true;
							$(document).bind('click.MyClick', function(e){
								if(!$firstClick && $(e.target).closest('.modal_wrap').length == 0
									|| $(e.target).closest('.close').length == 1
									|| $(e.target).closest($('#buy_order .btn-f.gr')).length == 1) {
									$modal.fadeOut();
									$mod.fadeOut();
									$(document).unbind('click.MyClick');
								}
								$firstClick = false;
							});
						}
					} else {
						$('#basket_form input').click();
					}
				}
		    }
		});
	});
	$(document).on('click', '[data-in-basket]', function(){
		var $this = $(this);
		var $product_id = $this.data("in-basket");
		var $quantity = $this.parent().find('.value').val();
		var $data = new FormData;
		if($product_id == '') return;
		$data.append('product_id', $product_id);
		$data.append('quantity', ($quantity>0)?$quantity:1);
		$.ajax({
		    url: '/ajax/addBasket.php',
		    data: $data,
		    contentType: false,
		    processData: false,
		    dataType: 'json',
		    type: 'POST',
		    success: function(resp){
		    	$form = $('#buy_order_basket .wr');
		    	$products = '';
		    	if(!$.isEmptyObject(resp)) {
		    		for(var i in resp) {
		    			$('.item-'+resp[i].ID).find('.price span').text(priceFormat(resp[i].PRICE));
					}
					$form.parents('#buy_order_basket').find('.total_count span').text(priceFormat(resp.TOTAL_PRICE));
					BX.onCustomEvent('OnBasketChange');
				}
		    }
		});
	});
	if($('.personal_area').length > 0) {
		setTimeout(function(){
			$('.personal_area > .wrap').css('height', $('.menu-lk .wrap').outerHeight());
		}, 200);
		$(window).resize(function(){
			$('.personal_area > .wrap').css('height', $('.menu-lk .wrap').outerHeight());
		});
	}
	$(document).on('submit', '#call form', function(){
		var $this = $(this);
		var $data = new FormData($this[0]);
		$.ajax({
		    url: '/ajax/zvonok.php',
		    data: $data,
		    contentType: false,
		    processData: false,
		    dataType: 'json',
		    type: 'POST',
		    success: function(resp){
		    	$this.find('.block-e').empty();
		        if(resp.DONE != 'Y' && !$.isEmptyObject(resp.ERRORS)) {
		        	for(var i in resp.ERRORS) {
		        		$this.find('.block-e').append('<div class="error">'+resp.ERRORS[i]+'</div>');
		        	}
		        } else if(resp.DONE == 'Y') {
		        	$this.parents('.modal_wrap:eq(0)').find('.wrap-content:eq(0)').hide();
		        	$this.parents('.modal_wrap:eq(0)').find('.wrap-content:eq(1)').fadeIn();
		        	checkSize($('#call'));
		        }
		    }
		});
		return false;
	});
	$(document).on('submit', '#contact_form form', function(){
		var $this = $(this);
		var $data = new FormData($this[0]);
		$.ajax({
		    url: '/ajax/new-question.php',
		    data: $data,
		    contentType: false,
		    processData: false,
		    dataType: 'json',
		    type: 'POST',
		    success: function(resp){
		    	$this.find('.suc').empty();
		    	if(resp.DONE == 'Y') {
		    		$this.find('.suc').append('<div class="success">Ваше сообщение отправлено, мы скоро свяжемся с вами</div>');
		    	} else alert(resp.ERRORS);
		    }
		});
		return false;
	});
	$(document).on('click', '.shop-l .input.radio', function(){
		var $this = $(this);
		var $txt = $this.find('span').text();
		if($this.find('input:radio').is(':checked')) $('.txt-info b').text($txt);
	});
	$(document).on('click', 'a.add-b', function(e){
		var $this = $(this);
		$this.parents('td:eq(0)').find('.input.add-b').fadeIn();
		$this.hide();
		e.preventDefault();
	});
	$(document).on('click', '.block_filter .name', function(){
		var $this = $(this);
		var $blockMain = $this.parents('.block_filter:eq(0)');
		if($blockMain.find('.wrap-b').css('display') !== 'block') {
			$blockMain.find('.wrap-b').slideDown();
			$blockMain.find('.fas').removeClass('fa-angle-down').addClass('fa-angle-up');
		} else {
			$blockMain.find('.wrap-b').slideUp();
			$blockMain.find('.fas').removeClass('fa-angle-up').addClass('fa-angle-down');
		}
	});
	$(document).on('click', '.cat_b .name-c', function(e){
		if($(e.target).closest('a').length == 0) {
			var $this = $(this);
			var $blockMain = $this.parents('.cat_b:eq(0)');
			if($blockMain.find('.wrap-c').css('display') !== 'block') {
				$blockMain.find('.wrap-c').slideDown();
				$blockMain.find('.fas').removeClass('fa-angle-down').addClass('fa-angle-up');
			} else {
				$blockMain.find('.wrap-c').slideUp();
				$blockMain.find('.fas').removeClass('fa-angle-up').addClass('fa-angle-down');
			}
		}
	});
	$(document).on('click', '.filter_mobile', function(){
		var $this = $(this);
		var $blockMain = $('.filter');
		if($blockMain.css('display') !== 'block') {
			$blockMain.slideDown();
			$this.find('.fas').removeClass('fa-angle-down').addClass('fa-times');
		} else {
			$blockMain.slideUp();
			$this.find('.fas').removeClass('fa-times').addClass('fa-angle-down');
		}
	});
	$(".simple-c a, .block-c .btn-applic").click(function () {
		var elementClick = $(this).attr("href")
		var destination = $(elementClick).offset().top;
		jQuery("html:not(:animated),body:not(:animated)").animate({scrollTop: destination}, 800);
		return false;
	});
	$(document).on('focusin', '.upload input:text', function(){
		var $this = $(this);
		$this.blur();
	});

	$(document).on('change', '.upload input:file', function(){
		var $this = $(this);
		var $name = $this[0].files.item(0).name;
		var $inp = $this.parents('.upload').find('input:text');
		if($name.length > 0) {
			$inp.attr('placeholder', $name);
		} else {
			$inp.attr('placeholder', 'Загрузите файл');
		}
	});
	$(document).on('click', '.input.radio input', function(){
		var $radio = $(this);
		var $block = $radio.parents('.radio:eq(0)');
		var $name = $radio.attr('name');
		var $radioCheck = $('[name="'+$name+'"]');
		for(var i = 0; i < $radioCheck.length; i++) {
			$radioCheck.eq(i).parents('.radio:eq(0)').removeClass('active');
		}
		if($radio.prop('checked') != false) {
			$block.addClass('active');
			$radio.attr('checked', 'checked');
		} else {
			$radio.removeAttr('checked');
			$block.removeClass('active');
		}
	});
	function checkModification() {
		var $check = true;
		$('[data-modification-id]').each(function(){
			if($(this).is(':checked'))
				$check = false;
		});
		return $check;
	}
	function slickReload($id) {
		var $err = false;
		try {
			$('.gallery-'+$id+' ul').slick('unslick');
		} catch(e) {
			$err = true;
		}
		if(!$err) {
			$('.gallery-'+$id+' ul').slick('unslick').slick({
                fade: true,
                asNavFor: '.gallery-prev-'+$id+' ul'
            });
            $('.gallery-prev-'+$id+' ul').slick('unslick').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                prevArrow: false,
                nextArrow: false,
                focusOnSelect: true,
                asNavFor: '.gallery-'+$id+' ul'
            });
        } else {
        	$('.gallery-'+$id+' ul').slick({
                fade: true,
                asNavFor: '.gallery-prev-'+$id+' ul'
            });
            $('.gallery-prev-'+$id+' ul').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                prevArrow: false,
                nextArrow: false,
                focusOnSelect: true,
                asNavFor: '.gallery-'+$id+' ul'
            });
        }
	}
	$(document).on('change', '[data-modification-id]', function(){
		var $this = $(this);
		var $price = $this.data('modification-price');
		var $productPrice = $this.data('product-price');
		var $id = $this.data('modification-id');
		$('.slider-cart').addClass('load');
		if($this.is(':checked')) {
			if($('.gallery-'+$id).length == 0) {
				var $data = new FormData();
				$data.append('gallery_id', $id);
				$.ajax({
				    url: '/ajax/gallery.php',
				    data: $data,
				    contentType: false,
				    processData: false,
				    dataType: 'json',
				    type: 'POST',
				    success: function(resp){
				    	if(resp.hasOwnProperty('gallery')) {
				    		var gallery = '';
            	    			gallery += '<div class="slider-cart gallery-'+resp.gallery.ID+'">';
            	    			gallery += '<ul>';
            	    				if($.isArray(resp.gallery.IMAGES)) {
            	    					for(var i in resp.gallery.IMAGES) {
            	    						gallery += '<li>';
            	    						gallery += '<a href="'+resp.gallery.IMAGES[i].SRC+'" data-fancybox="images" class="prev"></a>';
            	    						gallery += '<img src="'+resp.gallery.IMAGES[i].SRC+'" alt="'+resp.gallery.IMAGES[i].NAME+'">';
            	    						gallery += '</li>';
            	    					}
            	    				}
            	    				gallery += '</ul>';
            	    			gallery += '</div>';
            	   			
            	    			gallery += '<div class="prev-cart gallery-prev-'+resp.gallery.ID+'">';
            	    				gallery += '<ul>';
            	    			        if($.isArray(resp.gallery.IMAGES)) {
            	    						for(var i in resp.gallery.IMAGES) {
            	    							gallery += '<li>';
            	    							gallery += '<a href="'+resp.gallery.IMAGES[i].SRC+'" data-fancybox="images" class="prev"></a>';
            	    							gallery += '<img src="'+resp.gallery.IMAGES[i].SRC+'" alt="'+resp.gallery.IMAGES[i].NAME+'">';
            	    							gallery += '</li>';
            	    						}
            	    					}
            	    			    gallery += '</ul>';
            	    			gallery += '</div>';
            	    			$('.gallery_area').empty().append(gallery);
            	   				$('.price-panel .pr').html('<span>'+priceFormat(parseInt($productPrice)+parseInt($price))+'</span> руб.');
								slickReload(resp.gallery.ID);
								$('.gallery-'+$id+', .gallery-prev-'+$id).fadeIn(function(){
									$('.main_slider').hide();
									$('.slider-cart.load').removeClass('load');
								});
				    		}
				    	}
				    });

			} else {
				$('.price-panel .pr').html('<span>'+priceFormat(parseInt($productPrice)+parseInt($price))+'</span> руб.');
				$('.main_slider').hide();
				$('.gallery-'+$id+', .gallery-prev-'+$id).fadeIn(function(){
					$(this).find('ul').slick('slickCurrentSlide');
					$('.slider-cart').removeClass('load');
				});
			}
			
		} else {
			$('.price-panel .pr').html('<span>'+priceFormat(parseInt($productPrice))+'</span> руб.');
			if(checkModification()) $('.main_slider').fadeIn(function(){
				$(this).find('ul').slick('slickCurrentSlide');
				$('.slider-cart').removeClass('load');
			});
			$('.gallery-'+$id+', .gallery-prev-'+$id).hide();
		}
	});

	$(document).on('click', '.input.checkbox input:checkbox', function(){
		var $this = $(this);
		if($this.is(':checked'))
			$this.parents('.input.checkbox:eq(0)').addClass('active');
		else
			$this.parents('.input.checkbox:eq(0)').removeClass('active');
	});
	$('[data-tab]').on('click', function(){
		var $this = $(this);
		$('[data-tab]').removeClass('active');
		$('[data-body]').removeClass('active');
		$('[data-body="'+$this.data('tab')+'"]').addClass('active');
		$this.addClass('active');
	});
	$('.pan-add.inst').on('click', function(){
		var $this = $(this);
		var $block = $this.parents('.add_info:eq(0)').find('.quest-i');
		$block.fadeIn();
		setTimeout(function(){
			$block.fadeOut();
		}, 7000);
	});
	$('.slider_main_cart ul').slick({
		fade: true,
		asNavFor: '.prev_main_cart ul'
	});
	$('.prev_main_cart ul').slick({
		slidesToShow: 3,
  		slidesToScroll: 1,
		prevArrow: false,
    	nextArrow: false,
    	focusOnSelect: true,
    	asNavFor: '.slider_main_cart ul'
	});
	$('[data-mob-menu]').on('click', function(){
		var $this = $(this);
		var $data = $this.data('mob-menu');
		var $menu = $($data);
		if($menu.css('display') != 'block') {
			$menu.slideDown(function(){
				$(this).css({
					height: $(window).height() - $('.mobile_header').outerHeight()
				});
			});
			if($data == '#menu_top') {
				$this.find('i').removeClass('fa-bars').addClass('fa-times');
			} else if ($data == '#menu_cat') {
				$this.addClass('active').find('i').removeClass('fa-angle-down').addClass('fa-times');
			}
		} else {
			$menu.slideUp();
			if($data == '#menu_top') {
				$this.find('i').removeClass('fa-times').addClass('fa-bars');
			} else if ($data == '#menu_cat') {
				$this.removeClass('active').find('i').removeClass('fa-times').addClass('fa-angle-down');
			}
		}
	});
	$('menu.cat').click(function(e){
		if($(e.target).closest('ul').length == 0) {
			var $this = $(this);
			var $modal = $('.modal_bg');
			$this.find('ul').slideToggle(function(){
				// if($('header').hasClass('new-header')) {
				// 	if($(this).css('display') != 'block') {
				// 		//$modal.fadeOut();
				// 		$('body').removeClass('hover-menu');
				// 	} else {
				// 		//$modal.fadeIn();
				// 		$('body').addClass('hover-menu');
				// 		// $(document).bind('click.cat', function(e){
				// 		// 	if($(e.target).closest('.top_header, .top_header a').length == 0) {
				// 		// 		$(document).unbind('click.cat');
				// 		// 		$modal.fadeOut();
				// 		// 		$('body').removeClass('hover-menu');
				// 		// 		$this.find('ul').slideUp();
				// 		// 	}
				// 		// });
				// 	}
				// }
			});
		}
	});

	if($(window).width() < 992) {

		$('.accordion > li').each(function(){
			if($(this).find('.wrap-menu').length) {
				$(this).addClass('parent');
			}
		});

		if($('.slider-cart').length) {
			try {
				$('.slider-cart').slick('unslick');
			} catch(e){}
		}

	}

	$(document).on('click', '.accordion li.parent a', function(e){
		$(this).parent().find('.wrap-menu').css('display', 'block');
		e.preventDefault();
	});

	$('.question .name').on('click', function(){
		$(this).parents('.question:eq(0)').find('.txt').slideToggle();
	});
	// $('.select').hover(function(){
	// 	var $this = $(this);
	// 	$this.find('ul').slideDown(function(){
	// 		$this.find('.fas').removeClass('fa-chevron-down').addClass('fa-chevron-up');
	// 	});
	// }, function(){
	// 	var $this = $(this);
	// 	$this.find('ul').slideUp(function(){
	// 		$this.find('.fas').removeClass('fa-chevron-up').addClass('fa-chevron-down');
	// 	});
	// });
	$(document).on('click', '.select', function(){
		var $this = $(this);
		var $ul = $this.find('ul');
		if($ul.css('display') != 'block') {
			$ul.slideDown(function(){
				$this.find('.fas').removeClass('fa-chevron-down').addClass('fa-chevron-up');
			});
			var $firstClick = true;
			$(document).bind('click.Select', function(){
				if(!$firstClick) {
					$this.find('ul').slideUp(function(){
						$this.find('.fas').removeClass('fa-chevron-up').addClass('fa-chevron-down');
					});
					$(document).unbind('click.Select');
				}
				$firstClick = false;
			});
		}
	});
	$(document).on('click', '.personal_area .change, .personal_area .txt-info', function(){
		var $this = $(this);
		var $input = $this.parents('.input:eq(0)');
		if(!$input.hasClass('active')) {
			$input.addClass('active');
			if($this.hasClass('change')) $this.text('отменить');
		} else {
			$input.removeClass('active');
			if($this.hasClass('change')) $this.text('изменить');
			$(document).unbind('click.MyClick');
		}
		var $firstClick = false;
		$(document).bind('click.MyClick', function(e){
			if(!$firstClick && $(e.target).closest($input.find('.inform')).length == 0) {
				$input.removeClass('active');
				if($this.hasClass('change')) $this.text('изменить');
				$input.find('.txt-info').text($input.find('.inform').val());
				$(document).unbind('click.MyClick');
			}
			$firstClick = false;
		});
	});
	$(document).on('click', '.select li', function(){
		var $this = $(this);
		var $select = $this.parents('.select:eq(0)').find('select');
		var $val = $this.data('value');
		$select.find('option').prop('selected', false);
		$select.find('option[value="'+$val+'"]').prop('selected', true);
		$select.parents('.select:eq(0)').find('.val').text($this.text());
		$select.change();
		$this.parent('ul').slideUp();
		$(document).unbind('click.Select');
	});
	$(document).on('click', '.sort_panel .select li', function(){
		var $this = $(this);
		var $select = $this.parents('.select:eq(0)').find('select');
		var $val = $this.data('value');
		window.location.href = ""+$this.data('value');
		// $select.find('option').prop('selected', false);
		// $select.find('option[value="'+$val+'"]').prop('selected', true);
		// $select.parents('.select:eq(0)').find('.val').text($this.text());
		$this.parent('ul').slideUp();
		$(document).unbind('click.Select');
	});
	// $(document).on('change', '.sort_select', function(){
	// 	console.log($(this).find('option:selected').val());
	// 	window.location.href = ""+$(this).find('option:selected').val();
	// });
	$('.slider').slick({
	  	slidesToShow: 4,
	  	slidesToScroll: 1,
	  	responsive: [
  		  	{
  		  	  breakpoint: 1200,
  		  	  settings: {
  		  	    slidesToShow: 3,
  		  	    slidesToScroll: 1,
  		  	  }
  		  	},
  		  	{
  		  	  breakpoint: 991,
  		  	  settings: {
  		  	    slidesToShow: 2,
  		  	    slidesToScroll: 1
  		  	  }
  		  	}
  		]
	});

	$('.ban-block .row').slick({
		slidesToShow: 4,
	  	slidesToScroll: 1,
	  	autoplay: true,
  		autoplaySpeed: 4000,
	  	responsive: [
  		  	{
  		  	  breakpoint: 1200,
  		  	  settings: {
  		  	    slidesToShow: 3,
  		  	    slidesToScroll: 1,
  		  	  }
  		  	},
  		  	{
  		  	  breakpoint: 991,
  		  	  settings: {
  		  	    slidesToShow: 3,
  		  	    slidesToScroll: 1,
  		  	    prevArrow: false,
    			nextArrow: false
  		  	  }
  		  	}
  		]
	});
	$('.news .wraps').slick({
		slidesToShow: 4,
	  	slidesToScroll: 1,
	  	prevArrow: false,
    	nextArrow: false,
	  	responsive: [
	  		{
  		  	  breakpoint: 1028,
  		  	  settings: {
  		  	    slidesToShow: 3,
  		  	    slidesToScroll: 1
  		  	  }
  		  	},
  		  	{
  		  	  breakpoint: 991,
  		  	  settings: {
  		  	    slidesToShow: 2,
  		  	    slidesToScroll: 1
  		  	  }
  		  	}
  		]
	});
	$(document).on('click', '[data-modal]', function(event){
		var $this = $(this);
		var $modal = $this.data('modal');
		var $mod = $('.modal_bg');
		$modal = $($modal);
		if($modal.css('display') != 'block') {

			checkSize($modal);
			if($(window).width() < 767) {
				$modal.find('.wrap-content').css('height', $(window).height());
			}
			$modal.fadeIn();
			$mod.fadeIn();
			var $firstClick = true;
			$(document).bind('click.MyClick', function(e){
				if(!$firstClick && $(e.target).closest('.modal_wrap').length == 0
					|| $(e.target).closest('.close').length == 1
					|| $(e.target).closest($('#buy_order .btn-f.gr')).length == 1) {
					$modal.fadeOut();
					$mod.fadeOut();
					$(document).unbind('click.MyClick');
				}
				$firstClick = false;
			});
			event.preventDefault();
		}
	});
	$(document).on('click', '.favorite a', function(e){
		title=document.title;
		url=document.location;

		try {
		
		  // Internet Explorer
		
		  window.external.AddFavorite(url, title);
		
		}
		
		catch (e) {
		
		  try {
		
		    // Mozilla
		
		    window.sidebar.addPanel(title, url, "");
		
		  }
		
		  catch (e) {
		
		    // Opera
		
		    if (typeof(opera)=="object") {
		
		      a.rel="sidebar";
		
		      a.title=title;
		
		      a.url=url;
		
		      return true;
		
		    }
		
		    else {
		
		      // Unknown
		
		      alert('Нажмите Ctrl-D чтобы добавить страницу в закладки');
		
		    }
		
		  }
		
		}

		e.preventDefault();
	});
	if($('.menu-lk').length > 0) {
		setTimeout(function(){
			$("#lk-area > .wrap").mCustomScrollbar({
				setHeight: $('.menu-lk').outerHeight(),
				theme:"dark-3"
			});
			$("#serv ul").mCustomScrollbar({
				setHeight: ($('.menu-lk').outerHeight() - 80),
				theme:"dark-3"
			});
		}, 300);
	}
});