<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);?>
<?
$templateLibrary = array('popup');
$currencyList = '';
if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}
$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList
);
unset($currencyList, $templateLibrary);

$strMainID = $this->GetEditAreaId($arResult['ID']);
$arItemIDs = array(
	'ID' => $strMainID,
	'PICT' => $strMainID.'_pict',
	'DISCOUNT_PICT_ID' => $strMainID.'_dsc_pict',
	'STICKER_ID' => $strMainID.'_sticker',
	'BIG_SLIDER_ID' => $strMainID.'_big_slider',
	'BIG_IMG_CONT_ID' => $strMainID.'_bigimg_cont',
	'SLIDER_CONT_ID' => $strMainID.'_slider_cont',
	'SLIDER_LIST' => $strMainID.'_slider_list',
	'SLIDER_LEFT' => $strMainID.'_slider_left',
	'SLIDER_RIGHT' => $strMainID.'_slider_right',
	'OLD_PRICE' => $strMainID.'_old_price',
	'PRICE' => $strMainID.'_price',
	'DISCOUNT_PRICE' => $strMainID.'_price_discount',
	'SLIDER_CONT_OF_ID' => $strMainID.'_slider_cont_',
	'SLIDER_LIST_OF_ID' => $strMainID.'_slider_list_',
	'SLIDER_LEFT_OF_ID' => $strMainID.'_slider_left_',
	'SLIDER_RIGHT_OF_ID' => $strMainID.'_slider_right_',
	'QUANTITY' => $strMainID.'_quantity',
	'QUANTITY_DOWN' => $strMainID.'_quant_down',
	'QUANTITY_UP' => $strMainID.'_quant_up',
	'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
	'QUANTITY_LIMIT' => $strMainID.'_quant_limit',
	'BASIS_PRICE' => $strMainID.'_basis_price',
	'BUY_LINK' => $strMainID.'_buy_link',
	'ADD_BASKET_LINK' => $strMainID.'_add_basket_link',
	'BASKET_ACTIONS' => $strMainID.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
	'COMPARE_LINK' => $strMainID.'_compare_link',
	'PROP' => $strMainID.'_prop_',
	'PROP_DIV' => $strMainID.'_skudiv',
	'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
	'OFFER_GROUP' => $strMainID.'_set_group_',
	'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
);
$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
$templateData['JS_OBJ'] = $strObName;

$strTitle = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"] != ''
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	: $arResult['NAME']
);
$strAlt = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"] != ''
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	: $arResult['NAME']
);
?>
<?define("IS_PRODUCT","Y");?>
<style>.breadblock{width:100% !important;}</style>
<div class="product-description new-template" id="<? echo $arItemIDs['ID']; ?>">

<div class="product-top">

	<div class="top-info-block">
		<div class="top-info-block-left">
			<h2><?=$arResult['NAME']?></h2>
			<span class="art"><b>Арт.</b> <?=$arResult['PROPERTIES']['ARTICLE']['VALUE']?></span>
		</div>

		<div class="top-info-block-right">
			<?if($arResult['CATALOG_QUANTITY']>0):?><span class="available">Есть в наличии</span><?endif;?>
			<?$APPLICATION->IncludeComponent(
					"bitrix:iblock.vote",
					"stars1",
					array(
						"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
						"IBLOCK_ID" => $arParams['IBLOCK_ID'],
						"ELEMENT_ID" => $arResult['ID'],
						"ELEMENT_CODE" => "",
						"MAX_VOTE" => "5",
						"VOTE_NAMES" => array("1", "2", "3", "4", "5"),
						"SET_STATUS_404" => "N",
						"DISPLAY_AS_RATING" => $arParams['VOTE_DISPLAY_AS_RATING'],
						"CACHE_TYPE" => $arParams['CACHE_TYPE'],
						"CACHE_TIME" => $arParams['CACHE_TIME']
					),
					$component,
					array("HIDE_ICONS" => "Y")
				);?>
		</div>


		<div class="top-info-block-right margin-block">
			<?if(!empty($arResult["PROPERTIES"]['PROIZVODITEL']['VALUE'])):?>
				<span class="sloznost-ust"><b>Производитель</b>: <?=$arResult['PROPERTIES']['PROIZVODITEL']['VALUE']?>

				<?CModule::IncludeModule('iblock');
				$res=CIBlockElement::GetList(Array(),Array("IBLOCK_ID"=>15, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "NAME"=>$arResult['PROPERTIES']['PROIZVODITEL']['VALUE']),false,false,Array("ID", "PREVIEW_PICTURE","NAME", "DATE_ACTIVE_FROM"));
				while($ob=$res->GetNextElement()){$arFields=$ob->GetFields();?>
							<img style="max-width:50px;max-height:20px;" alt="<?=$strTitle?>" title="<?=$strTitle?>" src="<?=CFile::GetPath($arFields['PREVIEW_PICTURE']);?>"/>
				<?}?>
				</span>
			<?endif;?>
			<span class="material">Материал: <?=$arResult['PROPERTIES']['Material']['VALUE']?></span>
        </div>

        <div class="clear"></div>
	</div>
    <?$i = 0;?>
	<div class="post-gallery">
		<div class="slider-wrap">
			<div class="slick-slider">
				<?if (!empty($arResult['DETAIL_PICTURE'])):?>
					<?$i++;?>
					<div>
						<?$file = CFile::ResizeImageGet($arResult['DETAIL_PICTURE']["ID"], array('width'=>380, 'height'=>285), BX_RESIZE_IMAGE_EXACT, true);?>
						<a class="fancybox" rel="gallery1" href="<?=$arResult['DETAIL_PICTURE']['SRC']?>"><img src="<?=$file['src']?>" alt="<?=$strTitle?>" title="<?=$strTitle?>" /></a>
					</div>
				<?endif?>
				<?if (!empty($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'])):?>
					<?foreach($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $arPhoto):?>
						<?$i++;?>
						<div>
							<?$file = CFile::ResizeImageGet($arPhoto, array('width'=>380, 'height'=>285), BX_RESIZE_IMAGE_EXACT, true);?>
							<a class="fancybox" rel="gallery1" href="<?=CFile::GetPath($arPhoto)?>"><img src="<?=$file["src"]?>" alt="<?=$strTitle?>" title="<?=$strTitle?>" /></a>
						</div>
					<?endforeach;?>
				<?endif?>
				<?if ($i > 0 && $i < 3):?>
					<?for ($i; $i < 3; $i++):?>
						<div>
							<img src="/images/empty.jpg">
						</div>
					<?endfor?>
				<?endif?>
			</div>
		</div>
		<div class="slider-line"></div>
	</div>
</div>
<div class="product-bottom" >
	<div class="product-bottom-left">
		<div class="product-bottom-top">
            <div class="price-wrap">
				<span class="cd-price detailprice pricefont">
					<font id="<?echo $arItemIDs['PRICE']; ?>">Цена: <?=$arResult['MIN_PRICE']['VALUE']?></font> <span>руб</span>
				</span>
            </div>
			<div class="detail-bot-left">
				<div class="detail-quant" style="display:none;">
					<form action="" class="cd-text-number">
						<input id="<? echo $arItemIDs['QUANTITY']; ?>" type="text" value="<? echo (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])	? 1 : $arResult['CATALOG_MEASURE_RATIO']); ?>">
					</form>
				</div>

				<a href="javascript:void(0);" class="buy" id="<? echo $arItemIDs['ADD_BASKET_LINK']; ?>" itemname="<?=$arResult['NAME']?>" itemimg="<?=$arResult['PREVIEW_PICTURE']['SRC']?>">КУПИТЬ</a>
				<?$minPrice = (isset($arResult['RATIO_PRICE']) ? $arResult['RATIO_PRICE'] : $arResult['MIN_PRICE']);?>
				<?############Купи в кредит###############?>
				<?
				    $order = array(
				        // Состав заказа
				        'items' => array(
				            array(
				                'title' => htmlspecialcharsEx($strTitle),
				                'qty' => 1,
				                'price' => $minPrice['VALUE']
				            ),
				        ),
				        'partnerId' => 'a06b0000020BMWcAAO', // ID Партнера в системе Банка (выдается Банком)
				        'partnerOrderId' => 'test_order_'.uniqid(), // Уникальный номер заказа в системе Партнера
				    );

				$json = json_encode($order);
				$base64 = base64_encode($json);
				$secretPhrase = 'hard-tuning-secret-0BMWcc8f';

				function signMessage($message, $secretPhrase) {
				    $message = $message.$secretPhrase;
				    $result = md5($message).sha1($message);
				    for ($i = 0; $i < 1102; $i++) {
				        $result = md5($result);
				    }
				    return $result;
				}
				$sign = signMessage($base64, $secretPhrase);

					/*
					echo '<pre>';
					print_r($minPrice['VALUE']);
					echo '</pre>';
					*/
				?>

			<script>
			        window.callbacks = [];

			        window.onload = function() {
			            for (var i = 0; i < this.callbacks.length; i++) {
			                this.callbacks[i].call();
			            }
			        };

			        window.myOnLoadFunction = function(KVK) {
			            var button, form;
			            form = KVK.ui("form", {
			                order:"<?=$base64;?>",
			                sign: "<?=$sign;?>",
			                type: "full"
			            });

			            window.callbacks.push(function() {
			                button = document.getElementById("open");
			                button.removeAttribute("disabled");
			                button.onclick = function() {
			                    // Открытие формы по нажатию кнопки
			                    form.open();
			                };
			            });
			        }
			</script>
			 <a href="javascript:void(0)" class="buy-kredit" id="open" rel="nofollow" >Купить в  кредит</a>
			<?############////Купи в кредит###############?>
				<div class="kredit-res"></div>
				<a href="javascript:PopUpShow3()" class="buy-kredit1" iid="<?=$arResult['ID']?>" iname="<?=$arResult['NAME']?>" iprice="<?=$arResult['PRICES']['BASE']['VALUE']?>">Купить в один клик</a>
				<?/*<a href="javascript:PopUpShow4()" class="want-discount want-detali" style="text-align: center;margin: 10px auto;padding:5px;font-size:15px;letter-spacing: 1px;" itemid="<?=$arResult['ID']?>" itemname="<?=$arResult['NAME']?>">заказать штатные детали</a>
					<span class="zakaz-det-title">Дешевле чем у всех!</span>*/?>
			</div>
            <div class="ptr-raiting">
				<div style="clear:both;"></div>
				<a href="javascript:void(0);" class="compare compare-detail" id="<? echo $arItemIDs['COMPARE_LINK']; ?>">Добавить к сравнению</a>
				<div style="clear:both;"></div>

				<div class="buy-delivery">
					<div class="buy-link">
						<a href="javascript:void(0);">Оплата и доставка</a>
						<span class="tooltip">
							<span class="table-block">
								<span class="block-vertical">
									<?$APPLICATION->IncludeComponent(
										"bitrix:main.include",
										".default",
										Array(
											"AREA_FILE_SHOW" => "file",
											"PATH" => "/include/buydelivery-indetail.php",
											"EDIT_TEMPLATE" => ""
										)
									);?>
								</span>
							</span>
						</span>
					</div>
					<div class="buy-link">
						<a href="javascript:void(0);">Купить с установкой</a>
						<span class="tooltip">
							<span class="table-block">
								<span class="block-vertical">
									<?$APPLICATION->IncludeComponent(
										"bitrix:main.include",
										".default",
										Array(
											"AREA_FILE_SHOW" => "file",
											"PATH" => "/include/buysetup-indetail.php",
											"EDIT_TEMPLATE" => ""
										)
									);?>
								</span>
							</span>
						</span>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>

		<div class="product-bottom-tabs">
			<div class="product-description-tabs tabs">
				<ul class="product-filter tabs__caption">
					<li class="active"><span>Описание</span></li>
					<li><span>Характеристики</span></li>
					<?/*<li><span>Отзывы</span></li>*/?>
				</ul>

				<div class="tabs__content active">

					<div class="card-text">
						<div class="text">
							<p><?=$arResult['DETAIL_TEXT']?></p>

						</div>
						<?if(!empty($arResult['PROPERTIES']['TEXTIMG']['VALUE'])):?>
						<div class="card-img">
							<img src="<?=CFile::GetPath($arResult['PROPERTIES']['TEXTIMG']['VALUE'])?>" style="width:260px;height:230px;" alt="">
						</div>
						<?endif;?>
					</div>
					<table>
						<tbody>
							<?foreach($arResult['PROPERTIES'] as $arProps):?>
								<?if($arProps['HINT']==''&&$arProps['VALUE']!=''):?>
							<tr>
								<td><?=$arProps['NAME']?></td>
								<td><?=$arProps['VALUE']?></td>
							</tr>
								<?endif;?>
							<?endforeach;?>
						</tbody>
					</table>
					<div id="vk_comments"></div>
					<script type="text/javascript">
					VK.Widgets.Comments("vk_comments", {limit: 20, attach: "*"});
					</script>
					</div>
				<div class="tabs__content">
					<table>
						<tbody>
							<?foreach($arResult['PROPERTIES'] as $arProps):?>
								<?if($arProps['HINT']==''&&$arProps['VALUE']!=''):?>
							<tr>
								<td><?=$arProps['NAME']?></td>
								<td><?=$arProps['VALUE']?></td>
							</tr>
								<?endif;?>
							<?endforeach;?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
    	<?if(!empty($arResult['PROPERTIES']['POKUPAUT']['VALUE'])){?>
    	<div class="ul-top catalog-item-top">
    		<h3>Дополнительно можно купить<span></span></h3>
			<?GLOBAL $arrFilterPok;
			$arrFilterPok = array(
				'ID' => $arResult['PROPERTIES']['POKUPAUT']['VALUE'],
			);
			$APPLICATION->IncludeComponent("bitrix:catalog.top", "itemlist-onmain", Array(
				"ACTION_VARIABLE" => "action",	// Название переменной, в которой передается действие
					"ADD_PROPERTIES_TO_BASKET" => "N",	// Добавлять в корзину свойства товаров и предложений
					"ADD_TO_BASKET_ACTION" => "ADD",	// Показывать кнопку добавления в корзину или покупки
					"BASKET_URL" => "/personal/cart/",	// URL, ведущий на страницу с корзиной покупателя
					"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
					"CACHE_GROUPS" => "Y",	// Учитывать права доступа
					"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
					"CACHE_TYPE" => "A",	// Тип кеширования
					"COMPONENT_TEMPLATE" => ".default",
					"CONVERT_CURRENCY" => "N",	// Показывать цены в одной валюте
					"DETAIL_URL" => "",	// URL, ведущий на страницу с содержимым элемента раздела
					"DISPLAY_COMPARE" => "N",	// Разрешить сравнение товаров
					"ELEMENT_COUNT" => "5",	// Количество выводимых элементов
					"ELEMENT_SORT_FIELD" => "sort",	// По какому полю сортируем элементы
					"ELEMENT_SORT_FIELD2" => "id",	// Поле для второй сортировки элементов
					"ELEMENT_SORT_ORDER" => "asc",	// Порядок сортировки элементов
					"ELEMENT_SORT_ORDER2" => "desc",	// Порядок второй сортировки элементов
					"FILTER_NAME" => "arrFilterPok",	// Имя массива со значениями фильтра для фильтрации элементов
					"HIDE_NOT_AVAILABLE" => "N",	// Не отображать товары, которых нет на складах
					"IBLOCK_ID" => "4",	// Инфоблок
					"IBLOCK_TYPE" => "catalog",	// Тип инфоблока
					"LINE_ELEMENT_COUNT" => "3",	// Количество элементов выводимых в одной строке таблицы
					"MESS_BTN_ADD_TO_BASKET" => "В корзину",	// Текст кнопки "Добавить в корзину"
					"MESS_BTN_BUY" => "Купить",	// Текст кнопки "Купить"
					"MESS_BTN_COMPARE" => "Сравнить",	// Текст кнопки "Сравнить"
					"MESS_BTN_DETAIL" => "Подробнее",	// Текст кнопки "Подробнее"
					"MESS_NOT_AVAILABLE" => "Нет в наличии",	// Сообщение об отсутствии товара
					"OFFERS_LIMIT" => "5",	// Максимальное количество предложений для показа (0 - все)
					"PARTIAL_PRODUCT_PROPERTIES" => "N",	// Разрешить добавлять в корзину товары, у которых заполнены не все характеристики
					"PRICE_CODE" => array(	// Тип цены
						0 => "BASE",
					),
					"PRICE_VAT_INCLUDE" => "Y",	// Включать НДС в цену
					"PRODUCT_ID_VARIABLE" => "id",	// Название переменной, в которой передается код товара для покупки
					"PRODUCT_PROPERTIES" => "",	// Характеристики товара
					"PRODUCT_PROPS_VARIABLE" => "prop",	// Название переменной, в которой передаются характеристики товара
					"PRODUCT_QUANTITY_VARIABLE" => "",	// Название переменной, в которой передается количество товара
					"PROPERTY_CODE" => array(	// Свойства
						0 => "",
						1 => "",
					),
					"SECTION_ID_VARIABLE" => "SECTION_ID",	// Название переменной, в которой передается код группы
					"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
					"SEF_MODE" => "N",	// Включить поддержку ЧПУ
					"SHOW_CLOSE_POPUP" => "N",	// Показывать кнопку продолжения покупок во всплывающих окнах
					"SHOW_DISCOUNT_PERCENT" => "N",	// Показывать процент скидки
					"SHOW_OLD_PRICE" => "N",	// Показывать старую цену
					"SHOW_PRICE_COUNT" => "1",	// Выводить цены для количества
					"TEMPLATE_THEME" => "blue",	// Цветовая тема
					"USE_PRICE_COUNT" => "N",	// Использовать вывод цен с диапазонами
					"USE_PRODUCT_QUANTITY" => "N",	// Разрешить указание количества товара
					"VIEW_MODE" => "SECTION",	// Показ элементов
					"ADD_PICT_PROP" => "-",	// Дополнительная картинка основного товара
					"LABEL_PROP" => "-",	// Свойство меток товара
				),
				false
			);?>
		</div>
		<?}?>
    </div>
	<?if(!empty($arResult['PROPERTIES']['AKSESSUAR']['VALUE'])):?>
	<?GLOBAL $arrFilterPok;
	$arrFilterPok= array(
	'ID' => $arResult['PROPERTIES']['AKSESSUAR']['VALUE'],
	);
	?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.top",
		"aksessuar-indetail",
		Array(
			"ACTION_VARIABLE" => "action",
			"ADD_PICT_PROP" => "-",
			"ADD_PROPERTIES_TO_BASKET" => "N",
			"ADD_TO_BASKET_ACTION" => "ADD",
			"BASKET_URL" => "/personal/cart/",
			"CACHE_FILTER" => "N",
			"CACHE_GROUPS" => "Y",
			"CACHE_TIME" => "36000000",
			"CACHE_TYPE" => "A",
			"COMPONENT_TEMPLATE" => ".default",
			"CONVERT_CURRENCY" => "N",
			"DETAIL_URL" => "",
			"DISPLAY_COMPARE" => "N",
			"ELEMENT_COUNT" => "5",
			"ELEMENT_SORT_FIELD" => "sort",
			"ELEMENT_SORT_FIELD2" => "id",
			"ELEMENT_SORT_ORDER" => "asc",
			"ELEMENT_SORT_ORDER2" => "desc",
			"FILTER_NAME" => "arrFilterPok",
			"HIDE_NOT_AVAILABLE" => "N",
			"IBLOCK_ID" => "4",
			"IBLOCK_TYPE" => "catalog",
			"LABEL_PROP" => "-",
			"LINE_ELEMENT_COUNT" => "3",
			"MESS_BTN_ADD_TO_BASKET" => "В корзину",
			"MESS_BTN_BUY" => "Купить",
			"MESS_BTN_COMPARE" => "Сравнить",
			"MESS_BTN_DETAIL" => "Подробнее",
			"MESS_NOT_AVAILABLE" => "Нет в наличии",
			"OFFERS_LIMIT" => "5",
			"PARTIAL_PRODUCT_PROPERTIES" => "N",
			"PRICE_CODE" => array("BASE"),
			"PRICE_VAT_INCLUDE" => "Y",
			"PRODUCT_ID_VARIABLE" => "id",
			"PRODUCT_PROPERTIES" => array(""),
			"PRODUCT_PROPS_VARIABLE" => "prop",
			"PRODUCT_QUANTITY_VARIABLE" => "",
			"PROPERTY_CODE" => array("75","76","78","BLOG_POST_ID","AKSESSUAR","ARTICLE","VES","KACHESTVO","BLOG_COMMENTS_CNT","vote_count","Material","MI_SOVETUEM","NEWITEM","NOVIE_POSTUP","OBIEM_PAMYATI","POPULAR","TOMODEL","PROIZVODITEL","RASSHIRENIE","rating","SLOZNOST_USTANOVKI","SPECIAL","Sroc_postavki","vote_sum","TOVAR_DNYA","EKRAN",""),
			"SECTION_ID_VARIABLE" => "SECTION_ID",
			"SECTION_URL" => "",
			"SEF_MODE" => "N",
			"SHOW_CLOSE_POPUP" => "N",
			"SHOW_DISCOUNT_PERCENT" => "N",
			"SHOW_OLD_PRICE" => "N",
			"SHOW_PRICE_COUNT" => "1",
			"TEMPLATE_THEME" => "blue",
			"USE_PRICE_COUNT" => "N",
			"USE_PRODUCT_QUANTITY" => "N",
			"VIEW_MODE" => "SECTION"
		)
	);?>
	<?endif;?>

    <div class="clear"></div>
</div>





<?
reset($arResult['MORE_PHOTO']);
$arFirstPhoto = current($arResult['MORE_PHOTO']);
?>
	<div class="">

<div id="<? echo $arItemIDs['BIG_SLIDER_ID']; ?>" style="display:none;">
<div id="<? echo $arItemIDs['BIG_IMG_CONT_ID']; ?>"><img id="<? echo $arItemIDs['PICT']; ?>" src="<? echo $arFirstPhoto['SRC']; ?>" alt="<? echo $strAlt; ?>" title="<? echo $strTitle; ?>"></div>
</div>

		<div class="bx_rt">
<?
$useBrands = ('Y' == $arParams['BRAND_USE']);
$useVoteRating = ('Y' == $arParams['USE_VOTE_RATING']);
unset($useVoteRating, $useBrands);

if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS'])
{
?>
<div class="item_info_section">
<?
	if (!empty($arResult['DISPLAY_PROPERTIES']))
	{
?>
	<dl>
<?
		foreach ($arResult['DISPLAY_PROPERTIES'] as &$arOneProp)
		{
?>
		<dt><? echo $arOneProp['NAME']; ?></dt><dd><?
			echo (
				is_array($arOneProp['DISPLAY_VALUE'])
				? implode(' / ', $arOneProp['DISPLAY_VALUE'])
				: $arOneProp['DISPLAY_VALUE']
			); ?></dd><?
		}
		unset($arOneProp);
?>
	</dl>
<?
	}
	if ($arResult['SHOW_OFFERS_PROPS'])
	{
?>
	<dl id="<? echo $arItemIDs['DISPLAY_PROP_DIV'] ?>" style="display: none;"></dl>
<?
	}
?>
</div>
<?
}
if ('' != $arResult['PREVIEW_TEXT'])
{
	if (
		'S' == $arParams['DISPLAY_PREVIEW_TEXT_MODE']
		|| ('E' == $arParams['DISPLAY_PREVIEW_TEXT_MODE'] && '' == $arResult['DETAIL_TEXT'])
	)
	{
?>
<div class="item_info_section">
<?
		echo ('html' == $arResult['PREVIEW_TEXT_TYPE'] ? $arResult['PREVIEW_TEXT'] : '<p>'.$arResult['PREVIEW_TEXT'].'</p>');
?>
</div>
<?
	}
}
if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']) && !empty($arResult['OFFERS_PROP']))
{
	$arSkuProps = array();
?>
<div class="item_info_section" style="padding-right:150px;" id="<? echo $arItemIDs['PROP_DIV']; ?>">
<?
	foreach ($arResult['SKU_PROPS'] as &$arProp)
	{
		if (!isset($arResult['OFFERS_PROP'][$arProp['CODE']]))
			continue;
		$arSkuProps[] = array(
			'ID' => $arProp['ID'],
			'SHOW_MODE' => $arProp['SHOW_MODE'],
			'VALUES_COUNT' => $arProp['VALUES_COUNT']
		);
		if ('TEXT' == $arProp['SHOW_MODE'])
		{
			if (5 < $arProp['VALUES_COUNT'])
			{
				$strClass = 'bx_item_detail_size full';
				$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
				$strWidth = (20*$arProp['VALUES_COUNT']).'%';
				$strSlideStyle = '';
			}
			else
			{
				$strClass = 'bx_item_detail_size';
				$strOneWidth = '20%';
				$strWidth = '100%';
				$strSlideStyle = 'display: none;';
			}
?>
	<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_cont">
		<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>
		<div class="bx_size_scroller_container"><div class="bx_size">
			<ul id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;margin-left:0%;">
<?
			foreach ($arProp['VALUES'] as $arOneValue)
			{
				$arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
?>
<li data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID']; ?>" data-onevalue="<? echo $arOneValue['ID']; ?>" style="width: <? echo $strOneWidth; ?>; display: none;">
<i title="<? echo $arOneValue['NAME']; ?>"></i><span class="cnt" title="<? echo $arOneValue['NAME']; ?>"><? echo $arOneValue['NAME']; ?></span></li>
<?
			}
?>
			</ul>
			</div>
			<div class="bx_slide_left" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>"></div>
			<div class="bx_slide_right" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>"></div>
		</div>
	</div>
<?
		}
		elseif ('PICT' == $arProp['SHOW_MODE'])
		{
			if (5 < $arProp['VALUES_COUNT'])
			{
				$strClass = 'bx_item_detail_scu full';
				$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
				$strWidth = (20*$arProp['VALUES_COUNT']).'%';
				$strSlideStyle = '';
			}
			else
			{
				$strClass = 'bx_item_detail_scu';
				$strOneWidth = '20%';
				$strWidth = '100%';
				$strSlideStyle = 'display: none;';
			}
?>
	<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_cont">
		<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>
		<div class="bx_scu_scroller_container"><div class="bx_scu">
			<ul id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;margin-left:0%;">
<?
			foreach ($arProp['VALUES'] as $arOneValue)
			{
				$arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
?>
<li data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID'] ?>" data-onevalue="<? echo $arOneValue['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>; display: none;" >
<i title="<? echo $arOneValue['NAME']; ?>"></i>
<span class="cnt"><span class="cnt_item" style="background-image:url('<? echo $arOneValue['PICT']['SRC']; ?>');" title="<? echo $arOneValue['NAME']; ?>"></span></span></li>
<?
			}
?>
			</ul>
			</div>
			<div class="bx_slide_left" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>"></div>
			<div class="bx_slide_right" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>"></div>
		</div>
	</div>
<?
		}
	}
	unset($arProp);
?>
</div>
<?
}
?>
<div class="item_info_section">
<?
if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
{
	$canBuy = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['CAN_BUY'];
}
else
{
	$canBuy = $arResult['CAN_BUY'];
}
$buyBtnMessage = ($arParams['MESS_BTN_BUY'] != '' ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCE_CATALOG_BUY'));
$addToBasketBtnMessage = ($arParams['MESS_BTN_ADD_TO_BASKET'] != '' ? $arParams['MESS_BTN_ADD_TO_BASKET'] : GetMessage('CT_BCE_CATALOG_ADD'));
$notAvailableMessage = ($arParams['MESS_NOT_AVAILABLE'] != '' ? $arParams['MESS_NOT_AVAILABLE'] : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE'));
$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);

$showSubscribeBtn = false;
$compareBtnMessage = ($arParams['MESS_BTN_COMPARE'] != '' ? $arParams['MESS_BTN_COMPARE'] : GetMessage('CT_BCE_CATALOG_COMPARE'));

if ($arParams['USE_PRODUCT_QUANTITY'] == 'Y')
{
	if ($arParams['SHOW_BASIS_PRICE'] == 'Y')
	{
		$basisPriceInfo = array(
			'#PRICE#' => $arResult['MIN_BASIS_PRICE']['PRINT_DISCOUNT_VALUE'],
			'#MEASURE#' => (isset($arResult['CATALOG_MEASURE_NAME']) ? $arResult['CATALOG_MEASURE_NAME'] : '')
		);
?>

<?
	}
?>
	<div class="item_buttons vam" style="display:none;">
		<span class="item_buttons_counter_block">
			<a href="javascript:void(0)" class="bx_bt_button_type_2 bx_small bx_fwb" id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>">-</a>

			<a href="javascript:void(0)" class="bx_bt_button_type_2 bx_small bx_fwb" id="<? echo $arItemIDs['QUANTITY_UP']; ?>">+</a>
		</span>
		<span class="item_buttons_counter_block" id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" style="display: <? echo ($canBuy ? '' : 'none'); ?>;">
<?
	if ($showBuyBtn)
	{
?>
			<a href="javascript:void(0);" class="bx_big bx_bt_button bx_cart" id="<? echo $arItemIDs['BUY_LINK']; ?>"><span></span><? echo $buyBtnMessage; ?></a>
<?
	}
	if ($showAddBtn)
	{
?>
			<a href="javascript:void(0);" class="bx_big bx_bt_button bx_cart" id="<? echo $arItemIDs['ADD_BASKET_LINK']; ?>"><span></span><? echo $addToBasketBtnMessage; ?></a>
<?
	}
?>
		</span>
		<span id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="bx_notavailable" style="display: <? echo (!$canBuy ? '' : 'none'); ?>;"><? echo $notAvailableMessage; ?></span>
<?
	if ($arParams['DISPLAY_COMPARE'] || $showSubscribeBtn)
	{
?>
		<span class="item_buttons_counter_block">
<?
		if ($arParams['DISPLAY_COMPARE'])
		{
?>
			<a href="javascript:void(0);" class="bx_big bx_bt_button_type_2 bx_cart" id="<? echo $arItemIDs['COMPARE_LINK']; ?>"><? echo $compareBtnMessage; ?></a>
<?
		}
		if ($showSubscribeBtn)
		{

		}
?>
		</span>
<?
	}
?>
	</div>
<?
	if ('Y' == $arParams['SHOW_MAX_QUANTITY'])
	{
		if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
		{
?>
	<p id="<? echo $arItemIDs['QUANTITY_LIMIT']; ?>" style="display: none;"><? echo GetMessage('OSTATOK'); ?>: <span></span></p>
<?
		}
		else
		{
			if ('Y' == $arResult['CATALOG_QUANTITY_TRACE'] && 'N' == $arResult['CATALOG_CAN_BUY_ZERO'])
			{
?>
	<p id="<? echo $arItemIDs['QUANTITY_LIMIT']; ?>"><? echo GetMessage('OSTATOK'); ?>: <span><? echo $arResult['CATALOG_QUANTITY']; ?></span></p>
<?
			}
		}
	}
}
else
{
?>
	<div class="item_buttons vam">
		<span class="item_buttons_counter_block" id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" style="display: <? echo ($canBuy ? '' : 'none'); ?>;">
<?
	if ($showBuyBtn)
	{
?>
			<a href="javascript:void(0);" class="bx_big bx_bt_button bx_cart" id="<? echo $arItemIDs['BUY_LINK']; ?>"><span></span><? echo $buyBtnMessage; ?></a>
<?
	}
	if ($showAddBtn)
	{
?>
		<a href="javascript:void(0);" class="bx_big bx_bt_button bx_cart" id="<? echo $arItemIDs['ADD_BASKET_LINK']; ?>"><span></span><? echo $addToBasketBtnMessage; ?></a>
<?
	}
?>
		</span>
		<span id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="bx_notavailable" style="display: <? echo (!$canBuy ? '' : 'none'); ?>;"><? echo $notAvailableMessage; ?></span>
<?
	if ($arParams['DISPLAY_COMPARE'] || $showSubscribeBtn)
	{
		?>
		<span class="item_buttons_counter_block">
	<?
	if ($arParams['DISPLAY_COMPARE'])
	{
		?>
		<a href="javascript:void(0);" class="bx_big bx_bt_button_type_2 bx_cart" id="<? echo $arItemIDs['COMPARE_LINK']; ?>"><? echo $compareBtnMessage; ?></a>
	<?
	}
	if ($showSubscribeBtn)
	{

	}
?>
		</span>
<?
	}
?>
	</div>
<?
}
unset($showAddBtn, $showBuyBtn);
?>
</div>
			<div class="clb"></div>
		</div>

		<div class="bx_md">

		</div>

		<div class="bx_lb">

<div class="tab-section-container">
<?/*
if ('Y' == $arParams['USE_COMMENTS'])
{
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.comments",
	"",
	array(
		"ELEMENT_ID" => $arResult['ID'],
		"ELEMENT_CODE" => "",
		"IBLOCK_ID" => $arParams['IBLOCK_ID'],
		"SHOW_DEACTIVATED" => $arParams['SHOW_DEACTIVATED'],
		"URL_TO_COMMENT" => "",
		"WIDTH" => "",
		"COMMENTS_COUNT" => "5",
		"BLOG_USE" => $arParams['BLOG_USE'],
		"FB_USE" => $arParams['FB_USE'],
		"FB_APP_ID" => $arParams['FB_APP_ID'],
		"VK_USE" => $arParams['VK_USE'],
		"VK_API_ID" => $arParams['VK_API_ID'],
		"CACHE_TYPE" => $arParams['CACHE_TYPE'],
		"CACHE_TIME" => $arParams['CACHE_TIME'],
		'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
		"BLOG_TITLE" => "",
		"BLOG_URL" => $arParams['BLOG_URL'],
		"PATH_TO_SMILE" => "",
		"EMAIL_NOTIFY" => $arParams['BLOG_EMAIL_NOTIFY'],
		"AJAX_POST" => "Y",
		"SHOW_SPAM" => "Y",
		"SHOW_RATING" => "N",
		"FB_TITLE" => "",
		"FB_USER_ADMIN_ID" => "",
		"FB_COLORSCHEME" => "light",
		"FB_ORDER_BY" => "reverse_time",
		"VK_TITLE" => "",
		"TEMPLATE_THEME" => $arParams['~TEMPLATE_THEME']
	),
	$component,
	array("HIDE_ICONS" => "Y")
);?>
<?
}*/
?>
</div>
		</div>
			<div style="clear: both;"></div>
	</div>

</div>

<?/*if(!empty($arResult['PROPERTIES']['POKUPAUT']['VALUE'])):
GLOBAL $arrFilterPok;
$arrFilterPok = array(
	'ID' => $arResult['PROPERTIES']['POKUPAUT']['VALUE'],
);
$APPLICATION->IncludeComponent("bitrix:catalog.top", "pokupaut-indetail", Array(
	"ACTION_VARIABLE" => "action",	// Название переменной, в которой передается действие
		"ADD_PROPERTIES_TO_BASKET" => "N",	// Добавлять в корзину свойства товаров и предложений
		"ADD_TO_BASKET_ACTION" => "ADD",	// Показывать кнопку добавления в корзину или покупки
		"BASKET_URL" => "/personal/cart/",	// URL, ведущий на страницу с корзиной покупателя
		"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"COMPONENT_TEMPLATE" => ".default",
		"CONVERT_CURRENCY" => "N",	// Показывать цены в одной валюте
		"DETAIL_URL" => "",	// URL, ведущий на страницу с содержимым элемента раздела
		"DISPLAY_COMPARE" => "N",	// Разрешить сравнение товаров
		"ELEMENT_COUNT" => "5",	// Количество выводимых элементов
		"ELEMENT_SORT_FIELD" => "sort",	// По какому полю сортируем элементы
		"ELEMENT_SORT_FIELD2" => "id",	// Поле для второй сортировки элементов
		"ELEMENT_SORT_ORDER" => "asc",	// Порядок сортировки элементов
		"ELEMENT_SORT_ORDER2" => "desc",	// Порядок второй сортировки элементов
		"FILTER_NAME" => "arrFilterPok",	// Имя массива со значениями фильтра для фильтрации элементов
		"HIDE_NOT_AVAILABLE" => "N",	// Не отображать товары, которых нет на складах
		"IBLOCK_ID" => "4",	// Инфоблок
		"IBLOCK_TYPE" => "catalog",	// Тип инфоблока
		"LINE_ELEMENT_COUNT" => "3",	// Количество элементов выводимых в одной строке таблицы
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",	// Текст кнопки "Добавить в корзину"
		"MESS_BTN_BUY" => "Купить",	// Текст кнопки "Купить"
		"MESS_BTN_COMPARE" => "Сравнить",	// Текст кнопки "Сравнить"
		"MESS_BTN_DETAIL" => "Подробнее",	// Текст кнопки "Подробнее"
		"MESS_NOT_AVAILABLE" => "Нет в наличии",	// Сообщение об отсутствии товара
		"OFFERS_LIMIT" => "5",	// Максимальное количество предложений для показа (0 - все)
		"PARTIAL_PRODUCT_PROPERTIES" => "N",	// Разрешить добавлять в корзину товары, у которых заполнены не все характеристики
		"PRICE_CODE" => array(	// Тип цены
			0 => "BASE",
		),
		"PRICE_VAT_INCLUDE" => "Y",	// Включать НДС в цену
		"PRODUCT_ID_VARIABLE" => "id",	// Название переменной, в которой передается код товара для покупки
		"PRODUCT_PROPERTIES" => "",	// Характеристики товара
		"PRODUCT_PROPS_VARIABLE" => "prop",	// Название переменной, в которой передаются характеристики товара
		"PRODUCT_QUANTITY_VARIABLE" => "",	// Название переменной, в которой передается количество товара
		"PROPERTY_CODE" => array(	// Свойства
			0 => "",
			1 => "",
		),
		"SECTION_ID_VARIABLE" => "SECTION_ID",	// Название переменной, в которой передается код группы
		"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
		"SEF_MODE" => "N",	// Включить поддержку ЧПУ
		"SHOW_CLOSE_POPUP" => "N",	// Показывать кнопку продолжения покупок во всплывающих окнах
		"SHOW_DISCOUNT_PERCENT" => "N",	// Показывать процент скидки
		"SHOW_OLD_PRICE" => "N",	// Показывать старую цену
		"SHOW_PRICE_COUNT" => "1",	// Выводить цены для количества
		"TEMPLATE_THEME" => "blue",	// Цветовая тема
		"USE_PRICE_COUNT" => "N",	// Использовать вывод цен с диапазонами
		"USE_PRODUCT_QUANTITY" => "N",	// Разрешить указание количества товара
		"VIEW_MODE" => "SECTION",	// Показ элементов
		"ADD_PICT_PROP" => "-",	// Дополнительная картинка основного товара
		"LABEL_PROP" => "-",	// Свойство меток товара
	),
	false
);
endif;*/?>

<?
if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
{
	foreach ($arResult['JS_OFFERS'] as &$arOneJS)
	{
		if ($arOneJS['PRICE']['DISCOUNT_VALUE'] != $arOneJS['PRICE']['VALUE'])
		{
			$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'];
			$arOneJS['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'];
		}
		$strProps = '';
		if ($arResult['SHOW_OFFERS_PROPS'])
		{
			if (!empty($arOneJS['DISPLAY_PROPERTIES']))
			{
				foreach ($arOneJS['DISPLAY_PROPERTIES'] as $arOneProp)
				{
					$strProps .= '<dt>'.$arOneProp['NAME'].'</dt><dd>'.(
						is_array($arOneProp['VALUE'])
						? implode(' / ', $arOneProp['VALUE'])
						: $arOneProp['VALUE']
					).'</dd>';
				}
			}
		}
		$arOneJS['DISPLAY_PROPERTIES'] = $strProps;
	}
	if (isset($arOneJS))
		unset($arOneJS);
	$arJSParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => true,
			'SHOW_DISCOUNT_PERCENT' => ($arParams['SHOW_DISCOUNT_PERCENT'] == 'Y'),
			'SHOW_OLD_PRICE' => ($arParams['SHOW_OLD_PRICE'] == 'Y'),
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
			'OFFER_GROUP' => $arResult['OFFER_GROUP'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'SHOW_BASIS_PRICE' => ($arParams['SHOW_BASIS_PRICE'] == 'Y'),
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y')
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
		),
		'DEFAULT_PICTURE' => array(
			'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
			'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
		),
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'NAME' => $arResult['~NAME']
		),
		'BASKET' => array(
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'BASKET_URL' => $arParams['BASKET_URL'],
			'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		),
		'OFFERS' => $arResult['JS_OFFERS'],
		'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
		'TREE_PROPS' => $arSkuProps
	);
	if ($arParams['DISPLAY_COMPARE'])
	{
		$arJSParams['COMPARE'] = array(
			'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
			'COMPARE_PATH' => $arParams['COMPARE_PATH']
		);
	}
}
else
{
	$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
	if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties)
	{
?>
<div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
<?
		if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
		{
			foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo)
			{
?>
	<input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
<?
				if (isset($arResult['PRODUCT_PROPERTIES'][$propID]))
					unset($arResult['PRODUCT_PROPERTIES'][$propID]);
			}
		}
		$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
		if (!$emptyProductProperties)
		{
?>
	<table>
<?
			foreach ($arResult['PRODUCT_PROPERTIES'] as $propID => $propInfo)
			{
?>
	<tr><td><? echo $arResult['PROPERTIES'][$propID]['NAME']; ?></td>
	<td>
<?
				if(
					'L' == $arResult['PROPERTIES'][$propID]['PROPERTY_TYPE']
					&& 'C' == $arResult['PROPERTIES'][$propID]['LIST_TYPE']
				)
				{
					foreach($propInfo['VALUES'] as $valueID => $value)
					{
						?><label><input type="radio" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?></label><br><?
					}
				}
				else
				{
					?><select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
					foreach($propInfo['VALUES'] as $valueID => $value)
					{
						?><option value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>><? echo $value; ?></option><?
					}
					?></select><?
				}
?>
	</td></tr>
<?
			}
?>
	</table>
<?
		}
?>
</div>
<?
	}
	if ($arResult['MIN_PRICE']['DISCOUNT_VALUE'] != $arResult['MIN_PRICE']['VALUE'])
	{
		$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'];
		$arResult['MIN_BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arResult['MIN_BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'];
	}
	$arJSParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => (isset($arResult['MIN_PRICE']) && !empty($arResult['MIN_PRICE']) && is_array($arResult['MIN_PRICE'])),
			'SHOW_DISCOUNT_PERCENT' => ($arParams['SHOW_DISCOUNT_PERCENT'] == 'Y'),
			'SHOW_OLD_PRICE' => ($arParams['SHOW_OLD_PRICE'] == 'Y'),
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'SHOW_BASIS_PRICE' => ($arParams['SHOW_BASIS_PRICE'] == 'Y'),
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y')
		),
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'PICT' => $arFirstPhoto,
			'NAME' => $arResult['~NAME'],
			'SUBSCRIPTION' => true,
			'PRICE' => $arResult['MIN_PRICE'],
			'BASIS_PRICE' => $arResult['MIN_BASIS_PRICE'],
			'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
			'SLIDER' => $arResult['MORE_PHOTO'],
			'CAN_BUY' => $arResult['CAN_BUY'],
			'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
			'QUANTITY_FLOAT' => is_double($arResult['CATALOG_MEASURE_RATIO']),
			'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
			'STEP_QUANTITY' => $arResult['CATALOG_MEASURE_RATIO'],
		),
		'BASKET' => array(
			'ADD_PROPS' => ($arParams['ADD_PROPERTIES_TO_BASKET'] == 'Y'),
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'EMPTY_PROPS' => $emptyProductProperties,
			'BASKET_URL' => $arParams['BASKET_URL'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		)
	);
	if ($arParams['DISPLAY_COMPARE'])
	{
		$arJSParams['COMPARE'] = array(
			'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
			'COMPARE_PATH' => $arParams['COMPARE_PATH']
		);
	}
	unset($emptyProductProperties);
}
?>
<script type="text/javascript">
var <? echo $strObName; ?> = new JCCatalogElement(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
BX.message({
	ECONOMY_INFO_MESSAGE: '<? echo GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO'); ?>',
	BASIS_PRICE_MESSAGE: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_BASIS_PRICE') ?>',
	TITLE_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR') ?>',
	TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS') ?>',
	BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
	BTN_SEND_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS'); ?>',
	BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT') ?>',
	BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE'); ?>',
	BTN_MESSAGE_CLOSE_POPUP: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP'); ?>',
	TITLE_SUCCESSFUL: '<? echo GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK'); ?>',
	COMPARE_MESSAGE_OK: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK') ?>',
	COMPARE_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR') ?>',
	COMPARE_TITLE: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE') ?>',
	BTN_MESSAGE_COMPARE_REDIRECT: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT') ?>',
	SITE_ID: '<? echo SITE_ID; ?>'
});
</script>