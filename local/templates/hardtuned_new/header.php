<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
global $USER;
$arUser = null;
$IsAuthorized = false;
CModule::IncludeModule('iblock');
$car = false;

if($USER->IsAuthorized()) 
	$IsAuthorized = true;

if($IsAuthorized) {
	$rsUser = CUser::GetByID($USER->GetID());
	$arResult = $rsUser->Fetch();

	if($arResult) {
		$arUser = $arResult;

		$res = CIBlockSection::GetByID($arUser['UF_MAIN_CAR']);
		if($ar_res = $res->GetNext()) {
			if($ar_res['PICTURE']) {
				// $file = CFile::ResizeImageGet($ar_res['PICTURE'], array('width'=>79, 'height'=>79), BX_RESIZE_IMAGE_EXACT);
				// if($file['src']) {
				// 	$car = $file['src'];
				// }

				$car = CFile::GetPath($ar_res['PICTURE']);
			}
		}
	}
													
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-96106769-1"></script>
	<script>
	  	window.dataLayer = window.dataLayer || [];
	  	function gtag(){dataLayer.push(arguments);}
	  	gtag('js', new Date());
		
	  	gtag('config', 'UA-96106769-1');
	</script>
	<!-- Yandex.Metrika counter -->
	
	<script type="text/javascript" >
	    (function (d, w, c) {
	        (w[c] = w[c] || []).push(function() {
	            try {
	                w.yaCounter34923095 = new Ya.Metrika2({
	                    id:34923095,
	                    clickmap:true,
	                    trackLinks:true,
	                    accurateTrackBounce:true,
	                    webvisor:true,
	                    ecommerce:"dataLayer"
	                });
	            } catch(e) { }
	        });
	
	        var n = d.getElementsByTagName("script")[0],
	            s = d.createElement("script"),
	            f = function () { n.parentNode.insertBefore(s, n); };
	        s.type = "text/javascript";
	        s.async = true;
	        s.src = "https://mc.yandex.ru/metrika/tag.js";
	
	        if (w.opera == "[object Opera]") {
	            d.addEventListener("DOMContentLoaded", f, false);
	        } else { f(); }
	    })(document, window, "yandex_metrika_callbacks2");
	</script>
	<noscript><div><img src="https://mc.yandex.ru/watch/34923095" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
	<!-- /Yandex.Metrika counter -->

	<meta charset="UTF-8">
	<title><?$APPLICATION->ShowTitle()?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<?$APPLICATION->ShowHead()?>
	
	<?	
		$APPLICATION->AddHeadString('<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css"/>');
		$APPLICATION->AddHeadString('<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">');
		$APPLICATION->AddHeadString('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">');
		$APPLICATION->AddHeadString('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" />');
		$APPLICATION->AddHeadString('<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">');
		$APPLICATION->AddHeadString('<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>');
		$APPLICATION->AddHeadString('<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>');
		$APPLICATION->AddHeadString('<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>');
		$APPLICATION->AddHeadString('<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>');
		$APPLICATION->AddHeadString('<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>');
		$APPLICATION->AddHeadString('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css">');
		$APPLICATION->AddHeadString('<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>');

		$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/jquery.mCustomScrollbar.css");
		$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/main.css");


		$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.mousewheel-3.0.6.min.js");
		$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.mCustomScrollbar.min.js");
		$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/theaterJS.js");
		$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/main.js");
?>


	<!--[if lte IE 9]>
	<html class="ie9_all" lang="en">
		<![endif]-->
		<!--[if lte IE 8]>
		<link href="css/ie7.css" rel="stylesheet" type="text/css" />
		<![endif]-->
</head>
<body>

	<?$APPLICATION->ShowPanel();?>
		<?$APPLICATION->IncludeComponent(
			"lost:filter",
			"",
			Array()
		);?>
		<div id="main">
			
			<?/*if(!$USER->IsAdmin()):?>
			<div class="mobile_header d-lg-none">
				<div class="container">
					<div class="row">
						<div style="width: 100%;">
							<div class="btn-menu" data-mob-menu="#menu_top"> <i class="fas fa-bars"></i>
							</div>
							<menu class="menu_top menu_mob" id="menu_top">
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
								<div class="soc_block">
									<span>Мы в соцсетях:</span>
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
							</menu>
							<menu class="cat" id="mobile" data-mob-menu="#menu_cat">
								<span>Каталог товаров</span> <i class="fas fa-angle-down"></i>
							</menu>
							<div class="menu_mob" id="menu_cat">
								<?$APPLICATION->IncludeComponent("bitrix:menu", "top-cat", Array(
										"ALLOW_MULTI_SELECT" => "N", // Разрешить несколько активных пунктов одновременно
											"CHILD_MENU_TYPE" => "left",// Тип меню для остальных уровней
											"COMPONENT_TEMPLATE" => "leftmenu-cat",
											"DELAY" => "N",	// Откладывать выполнение шаблона меню
											"MAX_LEVEL" => "1",	// Уровень вложенности меню
											"MENU_CACHE_GET_VARS" => "",// Значимые переменные запроса
											"MENU_CACHE_TIME" => "3600",// Время кеширования (сек.)
											"MENU_CACHE_TYPE" => "N",// Тип кеширования
											"MENU_CACHE_USE_GROUPS" => "Y",// Учитывать права доступа
											"ROOT_MENU_TYPE" => "left",	// Тип меню для первого уровня
											"USE_EXT" => "Y",	// Подключать файлы с именами вида 	.тип_меню.menu_ext.php
										),
										false
									);?>
							</div>
							<?$APPLICATION->IncludeComponent(
								"bitrix:sale.basket.basket.line",
								"small_basket_mobile",
								Array(
									"HIDE_ON_BASKET_PAGES" => "Y",
									"PATH_TO_AUTHORIZE" => "",
									"PATH_TO_BASKET" => SITE_DIR."personal/cart/",
									"PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
									"PATH_TO_PERSONAL" => SITE_DIR."personal/",
									"PATH_TO_PROFILE" => SITE_DIR."personal/",
									"PATH_TO_REGISTER" => SITE_DIR."login/",
									"POSITION_FIXED" => "N",
									"SHOW_AUTHOR" => "N",
									"SHOW_EMPTY_VALUES" => "Y",
									"SHOW_NUM_PRODUCTS" => "Y",
									"SHOW_PERSONAL_LINK" => "Y",
									"SHOW_PRODUCTS" => "N",
									"SHOW_TOTAL_PRICE" => "Y"
								)
							);?>
						</div>
					</div>
				</div>
			</div>
			<header>
				<div class="top_panel d-none d-lg-block">
					<div class="container">
						<div class="row">
							<div class="col-md-7 col-xl-8">
								<menu class="menu_top">
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
							<div class="col-md-5 col-xl-4">
								<div class="soc_block">
									<span>Мы в соцсетях:</span>
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
						</div>
					</div>
				</div>
				<div class="top_header d-none d-md-block d-lg-none">
					<div class="container">
						<div class="row">
							<div class="col-6">
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
							</div>
							<div class="col bl-c">
								<div class="schedule">
									<?$APPLICATION->IncludeComponent(
										"bitrix:main.include",
										"",
										Array(
											"AREA_FILE_SHOW" => "file",
											"AREA_FILE_SUFFIX" => "inc",
											"EDIT_TEMPLATE" => "",
											"PATH" => "/include/top-txt.php"
										)
									);?>
								</div>
							</div>
							<div class="col bl-c">
								<?if(!$USER->IsAuthorized()):?>
									<span class="txt_top_log">Вход в мой гараж</span><a href="/login/" class="btn-header">Вход</a>
									<a href="/login/?register=yes" class="btn-header register">Регистрации</a>
								<?else:
									$rsUser = CUser::GetByID($USER->GetID());
									$arUser = $rsUser->Fetch();
									if(empty($arUser['NAME'])) $arUser['NAME'] = $arUser['LOGIN'];
								?>
									<a href="/personal/" class="btn-header register"><?=(strlen($arUser['NAME']) > 10)?substr($arUser['NAME'], 0, 5).'...':$arUser['NAME']?></a>
									<a href="<?=$APPLICATION->GetCurPage()?>?logout=yes" class="btn-header">Выход</a>
								<?endif;?>
							</div>
						</div>
					</div>
				</div>
				<div class="wrap_header">
					<div class="container">
						<div class="row">
							<div class="col-5">
								<div class="quote">
									<div class="row">
										<div class="col-md-7">
										<?$APPLICATION->IncludeComponent(
										"bitrix:main.include",
										"",
										Array(
											"AREA_FILE_SHOW" => "file",
											"AREA_FILE_SUFFIX" => "inc",
											"EDIT_TEMPLATE" => "",
											"PATH" => "/include/header_logo_txt.php"
										)
									);?>
									<div class="favorite">
										<a href="#" rel="sidebar">заполнить сайт</a>
									</div>
									</div>
									<div class="col-md-5">
										<div class="schedule">
											<?$APPLICATION->IncludeComponent(
												"bitrix:main.include",
												"",
												Array(
													"AREA_FILE_SHOW" => "file",
													"AREA_FILE_SUFFIX" => "inc",
													"EDIT_TEMPLATE" => "",
													"PATH" => "/include/header/phone.php"
												)
											);?>
											
										</div>
									</div>
									</div>
									
								</div>
							</div>
							<div class="col-2">
								<a href="/" class="logo">
									<?$APPLICATION->IncludeComponent(
										"bitrix:main.include",
										"",
										Array(
											"AREA_FILE_SHOW" => "file",
											"AREA_FILE_SUFFIX" => "inc",
											"EDIT_TEMPLATE" => "",
											"PATH" => "/include/header_logo.php"
										)
									);?>
								</a>
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
									<a href="#" data-modal="#call" class="mob call">Обратный звонок</a>
								</div>
							</div>
							<div class="col d-none d-lg-block">
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
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="top_header d-none d-lg-block second_top_header">
					<div class="container">
						<div class="row">
							<div class="col-6">
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
							</div>
							<div class="col bl-c">
								<div class="schedule">
									<?$APPLICATION->IncludeComponent(
										"bitrix:main.include",
										"",
										Array(
											"AREA_FILE_SHOW" => "file",
											"AREA_FILE_SUFFIX" => "inc",
											"EDIT_TEMPLATE" => "",
											"PATH" => "/include/top-txt.php"
										)
									);?>
								</div>
							</div>
							<div class="col bl-c">
								<?
									global $USER;
								?>
								<?if(!$USER->IsAuthorized()):?>
									<span class="txt_top_log">Вход в мой гараж</span><a href="/login/" class="btn-header">Вход</a>
									<a href="/login/?register=yes" class="btn-header register">Регистрации</a>
								<?else:
									$rsUser = CUser::GetByID($USER->GetID());
									$arUser = $rsUser->Fetch();
									if(empty($arUser['NAME'])) $arUser['NAME'] = $arUser['LOGIN'];
								?>
									<a href="/personal/" class="btn-header register"><?=(strlen($arUser['NAME']) > 10)?substr($arUser['NAME'], 0, 5).'...':$arUser['NAME']?></a>
									<a href="<?=$APPLICATION->GetCurPage()?>?logout=yes" class="btn-header">Выход</a>
								<?endif;?>
							</div>
						</div>
					</div>
				</div>
				<div class="panel_menu">
					<div class="search-title">
						<?$APPLICATION->IncludeComponent(
							"bitrix:main.include",
							"",
							Array(
								"AREA_FILE_SHOW" => "file",
								"AREA_FILE_SUFFIX" => "inc",
								"EDIT_TEMPLATE" => "",
								"PATH" => "/include/txt_filter.php"
							)
						);?>
					</div>
					<div class="container">
						<div class="row">
							<menu class="cat col-2 d-none d-lg-flex">
								<span>Каталог товаров</span>
								<?$APPLICATION->IncludeComponent("bitrix:menu", "top-cat", Array(
										"ALLOW_MULTI_SELECT" => "N", // Разрешить несколько активных пунктов одновременно
											"CHILD_MENU_TYPE" => "left",// Тип меню для остальных уровней
											"COMPONENT_TEMPLATE" => "leftmenu-cat",
											"DELAY" => "N",	// Откладывать выполнение шаблона меню
											"MAX_LEVEL" => "1",	// Уровень вложенности меню
											"MENU_CACHE_GET_VARS" => "",// Значимые переменные запроса
											"MENU_CACHE_TIME" => "3600",// Время кеширования (сек.)
											"MENU_CACHE_TYPE" => "N",// Тип кеширования
											"MENU_CACHE_USE_GROUPS" => "Y",// Учитывать права доступа
											"ROOT_MENU_TYPE" => "left",	// Тип меню для первого уровня
											"USE_EXT" => "Y",	// Подключать файлы с именами вида 	.тип_меню.menu_ext.php
										),
										false
									);?>
							</menu>
							<?$APPLICATION->ShowViewContent('lost_filter');?>
							<div class="mini_basket col-2 d-none d-lg-block">
								<?$APPLICATION->IncludeComponent(
									"bitrix:sale.basket.basket.line",
									"small_basket_dectop",
									Array(
										"HIDE_ON_BASKET_PAGES" => "Y",
										"PATH_TO_AUTHORIZE" => "",
										"PATH_TO_BASKET" => SITE_DIR."personal/cart/",
										"PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
										"PATH_TO_PERSONAL" => SITE_DIR."personal/",
										"PATH_TO_PROFILE" => SITE_DIR."personal/",
										"PATH_TO_REGISTER" => SITE_DIR."login/",
										"POSITION_FIXED" => "N",
										"SHOW_AUTHOR" => "N",
										"SHOW_EMPTY_VALUES" => "Y",
										"SHOW_NUM_PRODUCTS" => "Y",
										"SHOW_PERSONAL_LINK" => "Y",
										"SHOW_PRODUCTS" => "N",
										"SHOW_TOTAL_PRICE" => "Y"
									)
								);?>
							</div>
						</div>
					</div>
				</div>
			</header>
			<?else:*/?>
			<div class="mobile_header custom_header d-lg-none">
				<div class="container">
					<div class="row">
						<div style="width: 100%;" class="row_fl">
							<div class="btn-menu" data-mob-menu="#menu_top"> <i class="fas fa-bars"></i>
							</div>
							<menu class="menu_top menu_mob" id="menu_top">
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
								<div class="soc_block">
									<span>Мы в соцсетях:</span>
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
							</menu>
							<div class="lk_block">
									<button class="lk_block-title" type="button">Мой аккаунт и гараж</button>
									<div class="lk_block-wrap">
										<div class="lk_block-wr">
											<div class="wrap_lk-title">
												<?if(!$IsAuthorized):?>
													Мой аккаунт
												<?else:
													echo $arUser['LOGIN'];
												?>
													<br/>
													<b>
														Баллов: <?=($arUser['UF_BALLS'] < 0 ? '0': $arUser['UF_BALLS'])?>
													</b>
												<?endif;?>
											</div>
											<?if(!$IsAuthorized):?>
												<div class="wrap_lk-ava"></div>
											<?elseif($car):?>
												<div class="wrap_lk-ava" style="background: url('<?=$car?>') no-repeat; background-size: contain;"></div>
											<?endif;?>
											<?if(!$IsAuthorized):?>
												<a href="/login/" class="btn-product">Войти в аккаунт</a>
												<div class="wrap_lk-reg">
													Новый клиент? <a href="/login/?register=yes">Регистрация</a>
												</div>
												<br/>
											<?endif;?>
											<?if($IsAuthorized):?>
												<div class="wrap_lk-btnwrap">
													<ul>
														<li><a href="/personal/personalnye-dannye/">Учетная<br/>запись</a></li>
														<li><a href="/personal/istoriya-zakazov/">Заказы</a></li>
														<li><a href="/personal/zapomnennyy-tovary/">Список<br/>желаний</a></li>
													</ul>
												</div>
											<?else:?>
												<a href="/login/?register=yes" class="btn-product add" style="display: none;">Добавить автомобиль</a>
											<?endif;?>
											<div class="wrap_lk-setting">
												<ul>
													<li>Магазин автомобилей в вашем гараже</li>
													<li>Получить рекомендации по продукту</li>
													<li>Легко найти запчасти и аксессуары</li>
												</ul>
											</div>
											<?if($IsAuthorized):?>
												<br/>
												<a href="<?=$APPLICATION->GetCurPage()?>?logout=yes" class="btn-product">Выйти</a>
											<?endif;?>
										</div>
									</div>
								</div>
							<?$APPLICATION->IncludeComponent(
								"bitrix:sale.basket.basket.line",
								"small_basket_mobile",
								Array(
									"HIDE_ON_BASKET_PAGES" => "Y",
									"PATH_TO_AUTHORIZE" => "",
									"PATH_TO_BASKET" => SITE_DIR."personal/cart/",
									"PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
									"PATH_TO_PERSONAL" => SITE_DIR."personal/",
									"PATH_TO_PROFILE" => SITE_DIR."personal/",
									"PATH_TO_REGISTER" => SITE_DIR."login/",
									"POSITION_FIXED" => "N",
									"SHOW_AUTHOR" => "N",
									"SHOW_EMPTY_VALUES" => "Y",
									"SHOW_NUM_PRODUCTS" => "Y",
									"SHOW_PERSONAL_LINK" => "Y",
									"SHOW_PRODUCTS" => "N",
									"SHOW_TOTAL_PRICE" => "Y"
								)
							);?>
						</div>
					</div>
				</div>
			</div>
			
			<header class="new-header">
				<div class="top_panel d-none d-lg-block">
					<div class="container">
						<div class="row">
							<menu class="menu_top">
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
							<div class="schedule">
								<?$APPLICATION->IncludeComponent(
									"bitrix:main.include",
									"",
									Array(
										"AREA_FILE_SHOW" => "file",
										"AREA_FILE_SUFFIX" => "inc",
										"EDIT_TEMPLATE" => "",
										"PATH" => "/include/header/phone.php"
									)
								);?>
								
							</div>
							<div class="soc_block">
								<span>Мы в соцсетях:</span>
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
					</div>
				</div>
				<div class="top_header d-none d-md-block d-lg-none">
					<div class="container">
						<div class="row">
							<menu class="cat" id="mobile" data-mob-menu="#menu_cat">
								<span>Каталог товаров</span> <i class="fas fa-angle-down"></i>
							</menu>
							<div class="menu_mob" id="menu_cat">
								<?$APPLICATION->IncludeComponent("bitrix:menu", "top-cat", Array(
										"ALLOW_MULTI_SELECT" => "N", // Разрешить несколько активных пунктов одновременно
											"CHILD_MENU_TYPE" => "left",// Тип меню для остальных уровней
											"COMPONENT_TEMPLATE" => "leftmenu-cat",
											"DELAY" => "N",	// Откладывать выполнение шаблона меню
											"MAX_LEVEL" => "1",	// Уровень вложенности меню
											"MENU_CACHE_GET_VARS" => "",// Значимые переменные запроса
											"MENU_CACHE_TIME" => "3600",// Время кеширования (сек.)
											"MENU_CACHE_TYPE" => "N",// Тип кеширования
											"MENU_CACHE_USE_GROUPS" => "Y",// Учитывать права доступа
											"ROOT_MENU_TYPE" => "left",	// Тип меню для первого уровня
											"USE_EXT" => "Y",	// Подключать файлы с именами вида 	.тип_меню.menu_ext.php
										),
										false
									);?>
							</div>
							<div class="col-12">
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
							</div>
						</div>
					</div>
				</div>
				<div class="wrap_header">
					<div class="container">
						<div class="row">
							<div class="col-5">
								<div class="quote">
									<div class="row">
										<div class="col-md-7">
										<?$APPLICATION->IncludeComponent(
										"bitrix:main.include",
										"",
										Array(
											"AREA_FILE_SHOW" => "file",
											"AREA_FILE_SUFFIX" => "inc",
											"EDIT_TEMPLATE" => "",
											"PATH" => "/include/header_logo_txt.php"
										)
									);?>
									<div class="favorite">
										<a href="#" rel="sidebar">запомнить сайт</a>
									</div>
									</div>
									<div class="col-md-5">
										<div class="tracking_block">
											<div class="title_track">Отслеживание заказа</div>
											<span class="err"></span>
											<form action="">
												<input type="text" placeholder="Номер заказа или почта">
											</form>
										</div>
									</div>
									</div>
									
								</div>
							</div>
							<div class="col-2">
								<a href="/" class="logo">
									<?$APPLICATION->IncludeComponent(
										"bitrix:main.include",
										"",
										Array(
											"AREA_FILE_SHOW" => "file",
											"AREA_FILE_SUFFIX" => "inc",
											"EDIT_TEMPLATE" => "",
											"PATH" => "/include/header_logo.php"
										)
									);?>
								</a>
							</div>
							<div class="col-5 t-right">
								<div class="phone">
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
									<div class="free_phone">Звонок бесплатный</div>
									<a href="#" data-modal="#call" class="call" style="display: none;">Заказать обратный звонок</a>
									<a href="#" data-modal="#call" class="mob call">Обратный звонок</a>
								</div>
							
							<div class="sec-phone d-lg-flex">
								<div class="phone">
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
								</div>
								
							</div>
							<?$APPLICATION->IncludeComponent(
									"bitrix:sale.basket.basket.line",
									"small_basket_dectop_new",
									Array(
										"HIDE_ON_BASKET_PAGES" => "Y",
										"PATH_TO_AUTHORIZE" => "",
										"PATH_TO_BASKET" => SITE_DIR."personal/cart/",
										"PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
										"PATH_TO_PERSONAL" => SITE_DIR."personal/",
										"PATH_TO_PROFILE" => SITE_DIR."personal/",
										"PATH_TO_REGISTER" => SITE_DIR."login/",
										"POSITION_FIXED" => "N",
										"SHOW_AUTHOR" => "N",
										"SHOW_EMPTY_VALUES" => "Y",
										"SHOW_NUM_PRODUCTS" => "Y",
										"SHOW_PERSONAL_LINK" => "Y",
										"SHOW_PRODUCTS" => "N",
										"SHOW_TOTAL_PRICE" => "Y"
									)
								);?>
							</div>
						</div>
					</div>
				</div>
				<div class="top_header d-none d-lg-block second_top_header">
					<div class="container">
						<div class="row">
							<menu class="cat col-2">
								<span>Каталог товаров</span>
								<?$APPLICATION->IncludeComponent("bitrix:menu", "top-cat", Array(
										"ALLOW_MULTI_SELECT" => "N", // Разрешить несколько активных пунктов одновременно
											"CHILD_MENU_TYPE" => "left",// Тип меню для остальных уровней
											"COMPONENT_TEMPLATE" => "leftmenu-cat",
											"DELAY" => "N",	// Откладывать выполнение шаблона меню
											"MAX_LEVEL" => "1",	// Уровень вложенности меню
											"MENU_CACHE_GET_VARS" => "",// Значимые переменные запроса
											"MENU_CACHE_TIME" => "3600",// Время кеширования (сек.)
											"MENU_CACHE_TYPE" => "N",// Тип кеширования
											"MENU_CACHE_USE_GROUPS" => "Y",// Учитывать права доступа
											"ROOT_MENU_TYPE" => "left",	// Тип меню для первого уровня
											"USE_EXT" => "Y",	// Подключать файлы с именами вида 	.тип_меню.menu_ext.php
										),
										false
									);?>
							</menu>
								<div class="panel_search">
									<?$APPLICATION->IncludeComponent(
	"bitrix:search.title", 
	"search-t", 
	array(
		"CATEGORY_0" => array(
			0 => "iblock_catalog",
		),
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
		"USE_LANGUAGE_GUESS" => "Y",
		"COMPONENT_TEMPLATE" => "search-t",
		"CATEGORY_0_iblock_catalog" => array(
			0 => "4",
		)
	),
	false
);?>
								</div>
								<div class="schedule">
									<?$APPLICATION->IncludeComponent(
										"bitrix:main.include",
										"",
										Array(
											"AREA_FILE_SHOW" => "file",
											"AREA_FILE_SUFFIX" => "inc",
											"EDIT_TEMPLATE" => "",
											"PATH" => "/include/top-txt.php"
										)
									);?>
								</div>

								<div class="lk_block">
									<button class="lk_block-title" type="button">Мой аккаунт и гараж</button>
									<div class="lk_block-wrap">
										<div class="lk_block-wr">
											<div class="wrap_lk-title">
												<?if(!$IsAuthorized):?>
													Мой аккаунт
												<?else:
													echo $arUser['LOGIN'];
												?>
													<br/>
													<b>
														Баллов: <?=($arUser['UF_BALLS'] < 0 ? '0': $arUser['UF_BALLS'])?>
													</b>
												<?endif;?>
											</div>
											<?if(!$IsAuthorized):?>
												<div class="wrap_lk-ava"></div>
											<?elseif($car):?>
												<div class="wrap_lk-ava" style="background: url('<?=$car?>') no-repeat; background-size: contain;"></div>
											<?endif;?>
											<?if(!$IsAuthorized):?>
												<a href="/login/" class="btn-product">Войти в аккаунт</a>
												<div class="wrap_lk-reg">
													Новый клиент? <a href="/login/?register=yes">Регистрация</a>
												</div>
												<br/>
											<?endif;?>
											<?if($IsAuthorized):?>
												<div class="wrap_lk-btnwrap">
													<ul>
														<li><a href="/personal/personalnye-dannye/">Учетная<br/>запись</a></li>
														<li><a href="/personal/istoriya-zakazov/">Заказы</a></li>
														<li><a href="/personal/zapomnennyy-tovary/">Список<br/>желаний</a></li>
													</ul>
												</div>
											<?else:?>
												<a href="/login/?register=yes" class="btn-product add" style="display: none;">Добавить автомобиль</a>
											<?endif;?>
											<div class="wrap_lk-setting">
												<ul>
													<li>Магазин автомобилей в вашем гараже</li>
													<li>Получить рекомендации по продукту</li>
													<li>Легко найти запчасти и аксессуары</li>
												</ul>
											</div>
											<?if($IsAuthorized):?>
												<br/>
												<a href="<?=$APPLICATION->GetCurPage()?>?logout=yes" class="btn-product">Выйти</a>
											<?endif;?>
										</div>
									</div>
								</div>
								<?/*
									global $USER;
								?>
								<?if(!$USER->IsAuthorized()):?>
									<span class="txt_top_log">Вход в мой гараж</span><a href="/login/" class="btn-header">Вход</a>
									<a href="/login/?register=yes" class="btn-header register">Регистрации</a>
								<?else:
									$rsUser = CUser::GetByID($USER->GetID());
									$arUser = $rsUser->Fetch();
									if(empty($arUser['NAME'])) $arUser['NAME'] = $arUser['LOGIN'];
								?>
									<a href="/personal/" class="btn-header register"><?=(strlen($arUser['NAME']) > 10)?substr($arUser['NAME'], 0, 5).'...':$arUser['NAME']?></a>
									<a href="<?=$APPLICATION->GetCurPage()?>?logout=yes" class="btn-header">Выход</a>
								<?endif;*/?>
							</div>
					</div>
				</div>
				<div class="panel_menu">
					<div class="search-title">
						<?$APPLICATION->IncludeComponent(
							"bitrix:main.include",
							"",
							Array(
								"AREA_FILE_SHOW" => "file",
								"AREA_FILE_SUFFIX" => "inc",
								"EDIT_TEMPLATE" => "",
								"PATH" => "/include/txt_filter.php"
							)
						);?>
					</div>
					<div class="container">
						<div class="row">
							<?$APPLICATION->ShowViewContent('lost_filter');?>
						</div>
					</div>
				</div>
			</header>
			<?//endif;?>