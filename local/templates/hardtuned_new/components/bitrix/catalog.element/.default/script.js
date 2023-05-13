$(document).ready(function(){

	const magnitolaInit = () => {

		let price = 0

		$('.pricing-block-magnitola [data-price-prop]').each(function(){
			const $this = $(this)

			if($this.find('.item-tab.active').length > 0) {
				const pr = parseInt($this.find('.item-tab.active:eq()').attr('data-prop-magnitola-price'))
				if(pr > 0)
					price += pr
			} else if($this.find('.input.radio.active').length > 0) {
				const pr = parseInt($this.find('.input.radio.active:eq() [data-prop-magnitola-price]').attr('data-prop-magnitola-price'))
				if(pr > 0)
					price += pr
			}
		})

		$('.price-magnitola-block span').text(priceFormat(price)  + ' руб.')
	}

	magnitolaInit()

	$(document).on('click', '.pricing-block-magnitola .item-tab, .pricing-block-magnitola .input.radio', function(){
		setTimeout(() => {
			magnitolaInit()
		}, 300)
	})


	$(document).on('click', '[data-add-basket-magnitola]', function(e) {
		e.preventDefault()
		const $th = $(this)
		const products = []
		const props = []


		$('.pricing-block-magnitola [data-price-prop]').each(function(){
			const $this = $(this)
			

			if($this.find('.item-tab.active').length > 0) {
				const $id = parseInt($this.find('.item-tab.active:eq()').attr('data-prop-magnitola-id'))
				const $defaultId = parseInt($this.find('.item-tab.active:eq()').attr('data-prop-magnitola-default-id'))
				if($id > 0 && $defaultId > 0)
					products.push({
						'DEFAULT_ID': $defaultId,
						'PRODUCT_ID': $id
					})

			} else if($this.find('.input.radio.active').length > 0) {
				const $id = parseInt($this.find('.input.radio.active:eq() [data-prop-magnitola-id]').attr('data-prop-magnitola-id'))
				const $defaultId = parseInt($this.find('.input.radio.active:eq() [data-prop-magnitola-default-id]').attr('data-prop-magnitola-default-id'))
				if($id > 0 && $defaultId > 0)
					products.push({
						'DEFAULT_ID': $defaultId,
						'PRODUCT_ID': $id
					})
			}
		})

		$('.pricing-block-magnitola [data-actual-prop]').each(function(){
			const $this = $(this)
			

			if($this.find('.item-tab.active').length > 0) {
				const $name = $this.find('.item-tab.active:eq()').attr('data-name')
				const $value = $this.find('.item-tab.active:eq()').attr('data-value')

				if($name && $value)
					props.push({
						'NAME': $name,
						'VALUE': $value
					})

			} else if($this.find('.input.radio.active').length > 0) {
				const $name = $this.find('.input.radio.active:eq() [data-name]').attr('data-name')
				const $value = $this.find('.input.radio.active:eq() [data-value]').attr('data-value')
				if($id > 0)
					props.push({
						'NAME': $name,
						'VALUE': $value
					})
			}
		})

		const data = new FormData
		data.append('products', JSON.stringify(products))
		data.append('props', JSON.stringify(props))

		$.ajax({
		    url: '/ajax/addBasketMagnitola.php',
		    data,
		    contentType: false,
		    processData: false,
		    type: "POST",
		    success: function(resp){
		    	console.log('resp', resp)
		    	calculateBasket(resp, $th)
		    }
		});
	})

	
	const calculateBasket = (resp, $this) => {
		$form = $('#buy_order .wr');
		$form.empty();
		$products = '';

		var pict = (resp.PREVIEW_PICTURE) ? resp.PREVIEW_PICTURE : '';
		$products = '<div class="basket_produсt" id="modal-basket-item'+resp.PRODUCT_ID+'">';
			$products += '<div class="img">';
				$products += '<a href="'+resp.DETAIL_PAGE_URL+'">';
					if(pict != '') $products += '<img src="'+pict+'" alt="img"></div>';
				$products += '</a>';
			$products += '<div class="middle">';
				$products += '<div class="left">';
					$products += '<div class="art">';
						$products += 'Арт: ';
						$products += '<span>'+resp.PRODUCT_ID+'</span>';
					$products += '</div>';
					$products += '<div class="name"><a href="'+resp.DETAIL_PAGE_URL+'">'+resp.NAME+'</a></div>';
				$products += '</div>';
				$products += '<div class="bl-basket">';
					$products += '<div class="price">';
						// $products += '<span>'+priceFormat(resp.PRICE_INFO.PRICE)+'</span>';
						// $products += ' руб.';
					$products += '</div>';
				$products += '</div>';
				$products += '<div class="btn-c">';
					$products += '<a href="javascript:void(0)" data-remove="'+resp.ID+'" data-ecommerce=\''+JSON.stringify({
						"id": resp.PRODUCT_ID,
						"name": resp.NAME,
						"category": 'Магнитолы',
						"quantity":1
					})+'\' class="cansel modal-cansel">';
						$products += '<i class="fas fa-times"></i>';
					$products += '</a>';
				$products += '</div>';
			$products += '</div>';
		$products += '</div>';
		$form.prepend($products);

		$form.parents('#buy_order').find('.total-price').remove();
		BX.onCustomEvent('OnBasketChange');
		if($this.hasClass('btn-product') || $this.hasClass('btn-c-lilac')) {
			$this.attr('data-add-basket', '');
			$this.addClass('active').text('Добавлено');
			//$this.attr('onClick', "dataLayer.push({'event': 'klik','transactionId': '52896730'});");
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

	$(document).on('click', '[data-complect]', function() {
		const $this = $(this)
		$('[data-complect-block]').removeClass('active')
		$(`[data-complect-block="${$this.attr('data-complect')}"]`).addClass('active')
	})

	$(document).on('click', '[data-remember]', function(){
    	var $this = $(this);
    	var ID = $this.data('remember');
    	$data = new FormData;
    	$data.append('REMEMBER_ITEM', "Y");
    	$data.append('ID', ID);
    	$.ajax({
		    url: '/ajax/remember.php',
		    data: $data,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    success: function(resp){
		    	if(resp.DONE == 'N' && resp.ERRORS != '') {
		    		for(var i in resp.ERRORS) {
		    			alert(resp.ERRORS[i]);
		    		}
		    	} else if(resp.DONE == 'Y') {
		    		if(resp.hasOwnProperty('ADD')) {
		    			if(resp.ADD == "Y") {
		    				$this.find('a').text('Товар запомнен');
		    			}
		    		}
		    		if(resp.hasOwnProperty('REMOVE')) {
		    			if(resp.REMOVE == "Y") {
		    				$this.find('a').text('Запомнить товар');
		    			}
		    		}
		    	}
		    }
		});
    });
    if($(window).width() > 991)
    	$('.add_info.mob').remove();
    else
    	$('.add_info.pk').remove();
});