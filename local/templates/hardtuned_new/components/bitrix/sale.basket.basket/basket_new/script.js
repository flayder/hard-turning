window.onload = () => {
	$(document).on('click', '.promocode-block button', (e) => {
		e.preventDefault()

		const input = $('#promo-block')
		if(input.val().length > 0) {
			const data = new FormData
			data.append('coupon', input.val())

			$.ajax({
				type: 'POST',
				data,
				processData: false,
    			contentType: false,
				url: '/ajax/basketCoupon.php',
				success: (res) => {
					$.ajax({
						type: 'GET',
						url: window.location.href,
						dataType: 'html',
						success(res) {
							const basket = $(res).find('#buy_order_basket')
							if(basket) {
								$('#buy_order_basket').replaceWith(basket)
							}
						}
					})
				}
			})
		}
	})
}