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
<?$templateLibrary = array('popup');
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

<div class="page cart">
    <div class="container">
        <div class="row">
            <?$APPLICATION->IncludeComponent(
				"bitrix:breadcrumb",
				"breadcrump_new",
				Array(
					"PATH" => "",
					"SITE_ID" => "s1",
					"START_FROM" => "0"
				)
			);?>
            <h1><?=$arResult['NAME'];?></h1>
            <div class="col-lg-7">
                <div class="slider-cart">
                    <ul>
                        <li>
                            <a href="<?=$arResult['DETAIL_PICTURE']['SRC']?>" data-fancybox="images" class="prev"></a>
                            <img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="<?=$arResult['NAME']?>"></li>
                        <?foreach($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $arPhoto):?>
                        	<li>
                        	    <a href="<?=CFile::GetPath($arPhoto)?>" data-fancybox="images" class="prev"></a>
                            	<img src="<?=CFile::GetPath($arPhoto)?>" alt="<?=$arResult['NAME']?>">
                            </li>
                        <?endforeach;?>
                    </ul>
                </div>
                <div class="prev-cart">
                    <ul>
                        <li>
                            <a href="<?=$arResult['DETAIL_PICTURE']['SRC']?>" data-fancybox="images" class="prev"></a>
                            <img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="<?=$arResult['NAME']?>"></li>
                        <?foreach($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $arPhoto):?>
                        	<li>
                        	    <a href="<?=CFile::GetPath($arPhoto)?>" data-fancybox="images" class="prev"></a>
                            	<img src="<?=CFile::GetPath($arPhoto)?>" alt="<?=$arResult['NAME']?>">
                            </li>
                        <?endforeach;?>
                    </ul>
                </div>
                <div class="mob_panel">
                    <div class="cart-sidebar">
                        <div class="avail">
                            <div class="vendor">Арт.<?=$arResult['PROPERTIES']['ARTICLE']['VALUE']?></div>
                            <div class="avail-p">
                                <img src="<?=SITE_TEMPLATE_PATH?>/img/flag.jpg" alt="flag">
                                <span class="avail-v">
                                	<?if($arResult['PRODUCT']['QUANTITY'] > 0):?>
                           		    	В наличии
                           		    <?else:?>
                           		    	Нет в наличии
                           		    <?endif;?>
                           		</span>
                            </div>
                        </div>
                        <div style="clear: both;"></div>
                        <h2><?=$arResult['NAME'];?></h2>
                        <div class="descr">
                            <?=$arResult['DETAIL_TEXT']?>
                        </div>
                        <div class="price-panel">
                            <div class="pr">
                                <span><?=$arResult['PRICES']['BASE']['PRINT_VALUE']?></span>
                                руб.
                            </div>
                            <?if(!isset($arResult['BASKET_PRODUCTS'][$arResult['ID']])):?>
                            	<div class="counter">
                            	    <span class="btn-counter minus">
                            	        <i class="fas fa-minus"></i>
                            	    </span>
                            	    <input type="number" class="value" value="1">
                            	    <span class="btn-counter plus">
                            	        <i class="fas fa-plus"></i>
                            	    </span>
                            	</div>
                            <?endif;?>
                        </div>
                        <div style="clear: both;"></div>
                        <div class="panel-b">
                        	<?if(!isset($arResult['BASKET_PRODUCTS'][$arResult['ID']])):?>
								<a href="javascript:void(0)" class="btn-p btn-c-lilac" data-add-basket="<?=$arResult['ID']?>" data-quantity="1">
                            	    <span class="icon"></span>
                            	    Купить
                            	</a>
							<?else: ?>
								<a href="javascript:void(0)" class="btn-p btn-c-lilac active">
                            	    <span class="icon"></span>
                            	    Добавлено
                            	</a>
							<?endif;?>
                            
                            <a href="" data-modal="#buy_one_click" class="btn-p btn-c-tansp">Купить в 1 клик</a>
                        </div>
                    </div>
                    <div class="add_info">
                        <div class="pan-add cr">
                            <a href="javascript:void(0)">Купить в кредит</a>
                        </div>
                    </div>
                    <div class="add_info">
                        <div class="pan-add inst">
                            <a href="">Купить с установкой</a>
                            <i class="far help fa-question-circle"></i>
                            <span class="quest-i">
                                <span class="inf">
                                    Уточнить по телефону
                                    <?$APPLICATION->IncludeComponent(
										"bitrix:main.include",
										"",
										Array(
											"AREA_FILE_SHOW" => "file",
											"AREA_FILE_SUFFIX" => "inc",
											"EDIT_TEMPLATE" => "",
											"PATH" => "/include/phone_into_card.php"
										)
									);?>
                                </span>
                                <i class="far fa-question-circle"></i>
                            </span>
                        </div>
                    </div>
                    <div class="add_info">
                        <div class="pan-add favor">
                            <a href="javascript:void(0)" data-remember="<?=$arResult['ID'];?>">
                                <?if(isset($arResult['REMEMBERED_ITEMS'][$arResult['ID']])):?>
                                    Товар запомнен
                                <?else:?>
                                    Запомнить товар
                                <?endif;?>
                            </a>
                        </div>
                    </div>
                    <div class="add_info">
                        <div class="pan-add deliv">
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                Array(
                                    "AREA_FILE_SHOW" => "file",
                                    "AREA_FILE_SUFFIX" => "inc",
                                    "EDIT_TEMPLATE" => "",
                                    "PATH" => "/include/deliv_into_card.php"
                                )
                            );?>
                        </div>
                    </div>
                </div>
                <div class="block-c">
                    <div class="title">Описание</div>
                    <div class="wrap">
                        <?=$arResult['DETAIL_TEXT']?>
                    </div>
                </div>
                <?if(!empty($arResult['PROPERTIES']['sostav_komplekta']['FULL_INFO'])):?>
                <div class="block_main">
                    <div class="title">
                        <a href="javascript:void(0)">Состав комплекта</a>
                    </div>
                    <div class="slider">
                    	<?foreach ($arResult['PROPERTIES']['sostav_komplekta']['FULL_INFO'] as $key => $item):?>
                        	<div class="product-block">
                        	    <div class="wrap">
                        	        <div class="img">
                        	        	<?if(!empty($item['PREVIEW_PICTURE'])):?>
                        	            	<a href="<?=$item['DETAIL_PAGE_URL']?>">
                        	            		<img src="<?=$item['PREVIEW_PICTURE']?>" alt="<?=$item['NAME']?>">
                        	            	</a>
                        	            <?endif;?>
                        	        </div>
                        	        <div class="name">
                        	        	<a href="<?=$item['DETAIL_PAGE_URL']?>">
                        	        		<?=$item['NAME']?>
                        	        	</a>
                        	        </div>
                        	        <div class="price">
                        	            <?$price = (string)intval($item['PRICE_INFO']['PRICE']);?>
                                    	<span><?=(strlen($price)>3)?(substr($price, 0, strlen($price)-3).' '.substr($price, strlen($price)-3)):$price;?></span>
                        	            руб.
                        	        </div>
                        	        <?if(!isset($arResult['BASKET_PRODUCTS'][$item['ID']])):?>
										<button type="button" data-add-basket="<?=$item['ID']?>" data-quantity="1" class="btn-product">
											<span class="icon"></span>
											Купить
										</button>
									<?else: ?>
										<button type="button" class="btn-product active">
											<span class="icon"></span>
											Добавлено
										</button>
									<?endif;?>
                        	    </div>
                        	</div>
                        <?endforeach;?>
                    </div>
                </div>
                <?endif;?>
                <?if(!empty($arResult['DISPLAY_PROPERTIES'])):?>
                <div class="block-c">
                    <div class="title">Характеристики</div>
                    <div class="wrap">
                        <div class="char">
                            <ul>
                            	<?foreach ($arResult['DISPLAY_PROPERTIES'] as $key => $proprty): if(empty($proprty['VALUE'])) continue; ?>
                                	<li>
                                	    <span class="name"><?=$proprty['NAME']?></span>
                                	    <span class="val"><?=$proprty['VALUE']?></span>
                                	</li>
                                <?endforeach;?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?endif;?>
                <?if(!empty($arResult['PROPERTIES']['VIDEO']['VALUE'])):?>
                	<div class="youtube-b">
                	    <?=$arResult['PROPERTIES']['VIDEO']['~VALUE']?>
                	</div>
                <?endif;?>
                <div class="block-c">
                    <div class="title">Отзывы с Вконтакте</div>
                    <div class="wrap">
                        <div class="vk">
                            <script src="https://vk.com/js/api/openapi.js" type="text/javascript"></script>

                            <script type="text/javascript">
                                VK.init({apiId: 6612890, onlyWidgets: true});
                            </script>
                            
                            
                            <div id="vk_comments"></div>
                            <script type="text/javascript">
                                VK.Widgets.Comments("vk_comments", {
                                    limit: 10,  
                                    height: 500,
                                    attach: "*",
                                    autoPublish: 0,
                                    norealtime: 0,
                                    page_id: "<?=$arResult['ID']?>"
                                });
                            </script>

                        </div>
                    </div>
                </div>
                <div class="block-c" style="display: none;">
                    <div class="title">Отзывы с Facebook</div>
                    <div class="wrap">
                        <div class="vk">
                            <img src="<?=SITE_TEMPLATE_PATH?>/img/fb.jpg" alt="img"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="cart-sidebar">
                    <div class="avail">
                        <div class="vendor">Арт.<?=$arResult['PROPERTIES']['ARTICLE']['VALUE']?></div>
                        <div class="avail-p">
                            <img src="<?=SITE_TEMPLATE_PATH?>/img/flag.jpg" alt="flag">
                            <span class="avail-v">В наличии</span>
                        </div>
                    </div>
                    <div style="clear: both;"></div>
                    <h2><?=$arResult['NAME']?></h2>
                    <div class="descr">
                        <?=$arResult['PREVIEW_TEXT']?>
                    </div>
                    <div class="price-panel">
                        <div class="pr">
                            <span><?=$arResult['PRICES']['BASE']['PRINT_VALUE']?></span>
                            руб.
                        </div>
                        <?if(!isset($arResult['BASKET_PRODUCTS'][$arResult['ID']])):?>
                        	<div class="counter">
                        	    <span class="btn-counter minus">
                        	        <i class="fas fa-minus"></i>
                        	    </span>
                        	    <input type="number" class="value" value="1">
                        	    <span class="btn-counter plus">
                        	        <i class="fas fa-plus"></i>
                        	    </span>
                        	</div>
                        <?endif;?>
                    </div>
                    <div style="clear: both;"></div>
                    <div class="panel-b">
                        <?if(!isset($arResult['BASKET_PRODUCTS'][$arResult['ID']])):?>
							<a href="javascript:void(0)" class="btn-p btn-c-lilac" data-add-basket="<?=$arResult['ID']?>" data-quantity="1">
                        	    <span class="icon"></span>
                        	    Купить
                        	</a>
						<?else: ?>
							<a href="javascript:void(0)" class="btn-p btn-c-lilac active">
                        	    <span class="icon"></span>
                        	    Добавлено
                        	</a>
						<?endif;?>
                        <a href="" data-modal="#buy_one_click" data-buy1click-product-id="<?=$arResult['ID']?>" class="btn-p btn-c-tansp">Купить в 1 клик</a>
                    </div>
                </div>
                <div class="add_info">
                    <div class="pan-add cr">
                        <a href="javascript:void(0)">Купить в кредит</a>
                    </div>
                </div>
                <div class="add_info">
                    <div class="pan-add inst">
                        <a href="">Купить с установкой</a>
                        <i class="far help fa-question-circle"></i>
                        <span class="quest-i">
                            <span class="inf">
                                Уточнить по телефону
                                <?$APPLICATION->IncludeComponent(
									"bitrix:main.include",
									"",
									Array(
										"AREA_FILE_SHOW" => "file",
										"AREA_FILE_SUFFIX" => "inc",
										"EDIT_TEMPLATE" => "",
										"PATH" => "/include/phone_into_card.php"
									)
								);?>
                            </span>
                            <i class="far fa-question-circle"></i>
                        </span>
                    </div>
                </div>
                <?
                global $USER;
                if($USER->IsAuthorized()):?>
                <div class="add_info">
                    <div class="pan-add favor" data-remember="<?=$arResult['ID'];?>">
                        <a href="javascript:void(0)">
                            <?if(isset($arResult['REMEMBERED_ITEMS'][$arResult['ID']])):?>
                                Товар запомнен
                            <?else:?>
                                Запомнить товар
                            <?endif;?>
                        </a>
                    </div>
                </div>
                <?endif;?>
                <?if(!empty($arResult['PROPERTIES']['POKUPAUT']['FULL_INFO'])):?>
                <div class="buy-w">
                    <div class="title">С этим товаром покупают</div>
                    <?foreach ($arResult['PROPERTIES']['POKUPAUT']['FULL_INFO'] as $key => $item):?>
                    	<div class="product_of_day">
                            <div class="img">
                                <a href="<?=$item['DETAIL_PAGE_URL']?>">
									<img src="<?=$item['PREVIEW_PICTURE']?>" alt="image">
								</a>
                            </div>
                            <div class="middle">
                                <div class="name">
                                    <a href="<?=$item['DETAIL_PAGE_URL']?>">
										<?=$item['NAME']?>
									</a>
                                </div>
                                <div class="price">
                                	<?$price = (string)intval($item['PRICE_INFO']['PRICE']);?>
                                    <span><?=(strlen($price)>3)?(substr($price, 0, strlen($price)-3).' '.substr($price, strlen($price)-3)):$price;?></span>
                                    руб.
                                </div>
                                <div class="right-r">
                                    <?if(!isset($arResult['BASKET_PRODUCTS'][$item['ID']])):?>
										<button type="button" data-add-basket="<?=$item['ID']?>" data-quantity="1" class="btn-product">
											<span class="icon"></span>
											Купить
										</button>
									<?else: ?>
										<button type="button" class="btn-product active">
											<span class="icon"></span>
											Добавлено
										</button>
									<?endif;?>
                                </div>
                            </div>
                        </div>
                    <?endforeach;?>
                    <!-- <div class="load">Подгрузить еще</div> -->
                </div>
                <?endif;?>
                <div class="add_info">
                    <div class="pan-add deliv">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => "/include/deliv_into_card.php"
                            )
                        );?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>