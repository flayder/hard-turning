<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
			<footer>
				<div class="footer_menu">
					<div class="container">
						<div class="row">
							<div class="panel_search">
								<?$APPLICATION->IncludeComponent(
									"bitrix:search.title",
									"search-t",
									Array(
										"CATEGORY_0" => array(),
										"CATEGORY_0_TITLE" => "",
										"CHECK_DATES" => "N",
										"CONTAINER_ID" => "title-search",
										"INPUT_ID" => "title-search-input",
										"NUM_CATEGORIES" => "1",
										"ORDER" => "date",
										"PAGE" => "#SITE_DIR#search/index.php",
										"SHOW_INPUT" => "Y",
										"SHOW_OTHERS" => "N",
										"TOP_COUNT" => "5",
										"USE_LANGUAGE_GUESS" => "Y"
									)
								);?>
							</div>
							<menu class="col">
								<?$APPLICATION->IncludeComponent(
									"bitrix:menu",
									"topmenu_mob",
									Array(
										"ALLOW_MULTI_SELECT" => "N",
										"CHILD_MENU_TYPE" => "left",
										"DELAY" => "N",
										"MAX_LEVEL" => "1",
										"MENU_CACHE_GET_VARS" => array(""),
										"MENU_CACHE_TIME" => "3600",
										"MENU_CACHE_TYPE" => "N",
										"MENU_CACHE_USE_GROUPS" => "Y",
										"ROOT_MENU_TYPE" => "top",
										"USE_EXT" => "N"
									)
								);?>
							</menu>
						</div>
					</div>
				</div>
				<div class="container foot_panel">
					<div class="row">
						<div class="col-md-5">
							<a href="" class="foot_logo">
								<img src="<?=SITE_TEMPLATE_PATH?>/img/logo.png" alt="">
								<p>
									тюнинг автомобилей и
									<br/>
									интернет-магазина
									<br/>
									автотюнинга
								</p>
							</a>
							<div class="soc_block">
								<?$APPLICATION->IncludeComponent(
									"bitrix:main.include",
									"",
									Array(
										"AREA_FILE_SHOW" => "file",
										"AREA_FILE_SUFFIX" => "inc",
										"EDIT_TEMPLATE" => "",
										"PATH" => "/include/soc.php"
									)
								);?>
							</div>
						</div>
						<div class="col">
							<div class="schedule">

<?$APPLICATION->IncludeComponent(
									"bitrix:main.include",
									"",
									Array(
										"AREA_FILE_SHOW" => "file",
										"AREA_FILE_SUFFIX" => "inc",
										"EDIT_TEMPLATE" => "",
										"PATH" => "/include/time.php"
									)
								);?>
								
								<br/>
								<spam class="carts">
									<i class="fab fa-cc-mastercard"></i>
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 167 59">
										<defs>
											<symbol id="logo_koshelek_rus_compact_color" data-name="logo_koshelek_rus_compact_color" viewBox="0 0 344.39 154.77">
												<path class="cls-1" d="M168.72,87.74h5.41V99.85H178l7-12.11h5.87l-8.42,14.16V102l8.92,15.5h-6.12l-7.25-13h-3.85v13h-5.41Zm34.74,7.88c6.54,0,11.77,4.65,11.77,11.19S210,118,203.51,118s-11.73-4.61-11.73-11.19S197,95.61,203.47,95.61Zm0,17.85a6.67,6.67,0,1,0-6.33-6.66A6.36,6.36,0,0,0,203.51,113.46Zm16-17.35h5.07V113h6.66V96.12h5.07V113H243V96.12H248v21.37H219.51Zm43.79-.5c6.12,0,9.47,4.48,9.47,10.14a17,17,0,0,1-.17,2.05H257.9a6.05,6.05,0,0,0,6.41,5.66,10.1,10.1,0,0,0,6.12-2.35l2.1,3.81a13.52,13.52,0,0,1-8.59,3.06c-7.08,0-11.52-5.11-11.52-11.19C252.41,100.22,256.89,95.61,263.3,95.61Zm4.15,8.55c0-2.85-1.89-4.53-4.27-4.53a5.12,5.12,0,0,0-5.15,4.53Zm7.84,8.84c2.64-.38,4.48-2.6,4.48-10.18v-6.7h15.59v21.37H290V100.43h-5.2v2.39c0,9.3-2.47,14.67-9.55,14.88Zm35.29-17.39c6.12,0,9.47,4.48,9.47,10.14a17,17,0,0,1-.17,2.05H305.17a6.05,6.05,0,0,0,6.41,5.66,10.1,10.1,0,0,0,6.12-2.35l2.1,3.81a13.52,13.52,0,0,1-8.59,3.06c-7.08,0-11.52-5.11-11.52-11.19C299.68,100.22,304.17,95.61,310.58,95.61Zm4.15,8.55c0-2.85-1.89-4.53-4.27-4.53a5.12,5.12,0,0,0-5.15,4.53Zm9.8-8h5.32v8.17h2.6l5.2-8.17h5.91l-6.79,10.18v.08l7.63,11.1h-6.16l-5.61-8.67h-2.77v8.67h-5.32Z"/>
												<path class="cls-2" d="M243.37,22.79V73.32A1.37,1.37,0,0,1,242,74.69H231.68a1.37,1.37,0,0,1-1.37-1.37V22.79a1.37,1.37,0,0,1,1.37-1.37H242A1.37,1.37,0,0,1,243.37,22.79Zm80.43-1.37H312.25a1.37,1.37,0,0,0-1.31,1L301.8,52.24l-10-29.89a1.37,1.37,0,0,0-1.3-.93h-8.06a1.37,1.37,0,0,0-1.3.93L271,52.24l-9.14-29.86a1.37,1.37,0,0,0-1.31-1H249a1.38,1.38,0,0,0-1.11.57,1.35,1.35,0,0,0-.19,1.23l17,50.55a1.37,1.37,0,0,0,1.3.93h9.17a1.37,1.37,0,0,0,1.3-.93l9.95-29.53,9.95,29.53a1.37,1.37,0,0,0,1.3.93h9.17a1.37,1.37,0,0,0,1.3-.93l17-50.55a1.35,1.35,0,0,0-.19-1.23A1.38,1.38,0,0,0,323.8,21.42Zm17.37,0H330.85a1.37,1.37,0,0,0-1.37,1.37V73.32a1.37,1.37,0,0,0,1.37,1.37h10.32a1.37,1.37,0,0,0,1.37-1.37V22.79A1.37,1.37,0,0,0,341.17,21.42ZM224.33,73a1,1,0,0,1-.8,1.74H210.88a1.73,1.73,0,0,1-1.33-.62l-2.14-2.58a28,28,0,1,1,8.34-8.36ZM199.26,61.7,193.72,55a1.07,1.07,0,0,1,.82-1.76h11.59a16.37,16.37,0,0,0,.86-5.22c0-8.35-6.21-15.54-14.74-15.54s-14.74,7.2-14.74,15.54,6.21,15.44,14.74,15.44A14.3,14.3,0,0,0,199.26,61.7Zm-76.41,42.44c.45,3-.5,4.27-1.46,4.27s-2.36-1.22-3.9-3.64-2.08-5.11-1.33-6.5a2.15,2.15,0,0,1,2.87-.81C121.58,98.42,122.58,102.33,122.85,104.13Zm-14.13,6.58c3.06,2.59,4,5.67,2.37,7.84a5,5,0,0,1-4.11,1.85,7.3,7.3,0,0,1-4.68-1.7c-2.78-2.43-3.6-6.38-1.78-8.62a4.05,4.05,0,0,1,3.25-1.36A7.82,7.82,0,0,1,108.72,110.71Zm-5.12,25c13.19,0,27.5,4.52,43.34,18.56,1.59,1.41,3.7-.34,2.32-2.09-15.57-19.66-30-23.4-44.33-26.56C87.37,121.74,78.33,111.85,72,101c-1.25-2.16-1.81-1.78-1.93,1A61.41,61.41,0,0,0,71,114.3h0c-.71,0-1.42,0-2.14,0a45.5,45.5,0,1,1,45.5-45.5,46,46,0,0,1-.29,5.29,68.22,68.22,0,0,0-14.45-.27c-1.73.15-1.48,1-.18,1.19,15,2.72,25.37,12,27.74,29a.42.42,0,0,0,.76.17,68.84,68.84,0,1,0-59.08,33.5C78.91,137.66,88.92,135.7,103.6,135.7Z"/>
											</symbol>
										</defs>
										<g id="main">
											<use width="344.39" height="154.77" transform="translate(0 0.5) scale(0.37)" xlink:href="#logo_koshelek_rus_compact_color"/>
										</g>
									</svg>
									<i class="fab fa-cc-visa"></i>
								</spam>
								<br/>
								<a href="/karta-sayta/" class="map_s">Карта сайта</a>
							</div>
						</div>
						<div class="col">
							<div class="phone">
								<span>Звоните нам</span>
								<?$APPLICATION->IncludeComponent(
									"bitrix:main.include",
									"",
									Array(
										"AREA_FILE_SHOW" => "file",
										"AREA_FILE_SUFFIX" => "inc",
										"EDIT_TEMPLATE" => "",
										"PATH" => "/include/topphone.php"
									)
								);?>
								<a href="#" data-modal="#call" class="call">Заказать обратный звонок</a>
								<br/>
								<br/>
								<br/>
								<a href="/polzovatelskoe-soglashenie/" class="user_s">Пользовательское соглашение</a>
							</div>
						</div>
						<div class="col">
							<div class="phone">
								<span>или пишите</span>
								<?$APPLICATION->IncludeComponent(
									"bitrix:main.include",
									"",
									Array(
										"AREA_FILE_SHOW" => "file",
										"AREA_FILE_SUFFIX" => "inc",
										"EDIT_TEMPLATE" => "",
										"PATH" => "/include/topphone1.php"
									)
								);?>
								<div class="call-block">
									<?$APPLICATION->IncludeComponent(
										"bitrix:main.include",
										"",
										Array(
											"AREA_FILE_SHOW" => "file",
											"AREA_FILE_SUFFIX" => "inc",
											"EDIT_TEMPLATE" => "",
											"PATH" => "/include/chat.php"
										)
									);?>
								</div>
								<br/>
								<br/>
								<br/>
								<div class="favorite">
									<a href="#" rel="sidebar">запомнить сайт</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</footer>
		</div>
		<?$APPLICATION->IncludeComponent(
			"bitrix:main.include",
			"",
			Array(
				"AREA_FILE_SHOW" => "file",
				"AREA_FILE_SUFFIX" => "inc",
				"EDIT_TEMPLATE" => "",
				"PATH" => "/include/order-call.php"
			)
		);?>
		<div class="modal_wrap" id="buy">
			<div class="wrap-content">
				<div class="close">&times;</div>
				<div class="title">
					Купить с установкой
					<span class="small">Оставьте заявку и мы с Вами свяжемся</span>
				</div>
				<form action="">
					<div class="input">
						<div class="label col-3">
							<label for="">Имя</label>
							<span class="require">*</span>
						</div>
						<div class="input_field col-md-9">
							<input type="text" name="" id="" placeholder="Введите имя"></div>
					</div>
					<div class="input">
						<div class="label col-3">
							<label for="">Телефон</label>
							<span class="require">*</span>
						</div>
						<div class="input_field col-md-9">
							<input type="text" name="" id="" placeholder="Введите свой телефон"></div>
					</div>
					<div class="input">
						<input type="submit" value="Отправить" class="btn-mod"></div>
				</form>
			</div>
			<br/>
			<br/>
			<div class="wrap-content">
				<div class="close">&times;</div>
				<div class="title">
					Спасибо, что выбрали
					<span class="lilac">Hard Turnip</span>
					<span class="small">Мы обязательно вам перезвоним</span>
				</div>
			</div>
		</div>
		<?$APPLICATION->IncludeComponent(
			"bitrix:main.include",
			"",
			Array(
				"AREA_FILE_SHOW" => "file",
				"AREA_FILE_SUFFIX" => "inc",
				"EDIT_TEMPLATE" => "",
				"PATH" => "/include/buy_order.php"
			)
		);?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:main.include",
			"",
			Array(
				"AREA_FILE_SHOW" => "file",
				"AREA_FILE_SUFFIX" => "inc",
				"EDIT_TEMPLATE" => "",
				"PATH" => "/include/buy_1_click.php"
			)
		);?>
		<div class="modal_bg"></div>
	<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'ECH7k1BaMi';var d=document;var w=window;function l(){var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
</script>
<!-- {/literal} END JIVOSITE CODE -->
	<script src="<?=SITE_TEMPLATE_PATH?>/js/scripts.min.js"></script>
	<script src="<?=SITE_TEMPLATE_PATH?>/js/my.js"></script>
<script>
	// $('a[href="/personal/cart/"]').each(function(){
		
	// });
	$('[data-modal="#call"]').each(function(){
		$(this).attr('onClick', "dataLayer.push({'event': 'zvonok','transactionId': '52896736'});");
	});
	<?if($_REQUEST['ORDER_ID']):?>
		dataLayer.push({'event': 'well','transactionId': '52896712'});
	<?endif;?>
</script>
</body>
</html>