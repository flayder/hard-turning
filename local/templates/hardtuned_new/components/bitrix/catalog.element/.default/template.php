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
$this->setFrameMode(true);
global $USER;
//if(!$USER->IsAdmin())
    $APPLICATION->AddHeadScript("https://vk.com/js/api/openapi.js?159");

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
<?//if(!$USER->IsAdmin()):?>
    <script type="text/javascript">
      VK.init({apiId: 6612890, onlyWidgets: true});
    </script>
<?//endif;?>
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
                <div class="discount-img-block" style="top: 8px;">
                   <?foreach ($arResult['DISCOUNT'] as $key => $dis):
                       $style = '';
                       if(isset($dis["STYLES"])) {
                           foreach ($dis["STYLES"] as $n => $v) {
                               $style .= "{$n}: {$v};";
                           }
                       }
                   ?>
                       <img src="<?=$dis["ICON"]?>" alt="" style="width: <?=$dis["WIDTH"] ?? 'auto'?>; height: <?=$dis["HEIGHT"] ?? 'auto'?>;<?=$style?>">
                   <?endforeach;?>
               </div>
                <div class="slider-cart slider_main_cart main_slider">
                    <ul>
                        <li <?if($arResult['DISCOUNT'][0]):?>style="border-width: 2px;border-style: solid;/*border-color: transparent*/;border-image: url('<?=$arResult['DISCOUNT'][0]["BORDER_IMG"]?>') 100 repeat; border-radius: 0;"<?endif;?>>
                            <?//if($USER->IsAdmin()):?>
                                
                            <?//endif;?>
                            <a href="<?=(!empty($arResult['DETAIL_PICTURE']['SRC']))?$arResult['DETAIL_PICTURE']['SRC']:'/local/templates/hardtuned_new/components/bitrix/catalog.section/.default/images/no_photo.png'?>" data-fancybox="images" class="prev"></a>
                            <a href="<?=(!empty($arResult['DETAIL_PICTURE']['SRC']))?$arResult['DETAIL_PICTURE']['SRC']:'/local/templates/hardtuned_new/components/bitrix/catalog.section/.default/images/no_photo.png'?>" data-fancybox="images1"><img src="<?=(!empty($arResult['DETAIL_PICTURE']['SRC']))?$arResult['DETAIL_PICTURE']['SRC']:'/local/templates/hardtuned_new/components/bitrix/catalog.section/.default/images/no_photo.png'?>" alt="<?=$arResult['NAME']?>"></a></li>
                        <?foreach($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $arPhoto):?>
                        	<li <?if($arResult['DISCOUNT'][0]):?>style="border-width: 2px;border-style: solid;border-color: transparent;border-image: url('<?=$arResult['DISCOUNT'][0]["BORDER_IMG"]?>') 100 repeat;"<?endif;?>>
                                <?//if($USER->IsAdmin()):?>
                                <?//endif;?>
                        	    <a href="<?=$arPhoto['src']?>" data-fancybox="images" class="prev"></a>
                            	<a href="<?=$arPhoto['src']?>" data-fancybox="images1"><img src="<?=$arPhoto['src']?>" alt="<?=$arResult['NAME']?>"></a>
                            </li>
                        <?endforeach;?>
                    </ul>
                </div>
                <div class="prev-cart prev_main_cart main_slider">
                    <ul>
                        <li>
                            <a href="<?=(!empty($arResult['DETAIL_PICTURE']['SRC']))?$arResult['DETAIL_PICTURE']['SRC']:'/local/templates/hardtuned_new/components/bitrix/catalog.section/.default/images/no_photo.png'?>" data-fancybox="images" class="prev"></a>
                            <img src="<?=(!empty($arResult['DETAIL_PICTURE']['SRC']))?$arResult['DETAIL_PICTURE']['SRC']:'/local/templates/hardtuned_new/components/bitrix/catalog.section/.default/images/no_photo.png'?>" alt="<?=$arResult['NAME']?>"></li>
                        <?foreach($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $arPhoto):?>
                        	<li>
                        	    <a href="<?=$arPhoto['src']?>" data-fancybox="images" class="prev"></a>
                                <img src="<?=$arPhoto['src']?>" alt="<?=$arResult['NAME']?>">
                            </li>
                        <?endforeach;?>
                    </ul>
                </div>
				
				<div class="gallery_area"></div>

                <div class="mob_panel">
                    <div class="cart-sidebar" <?if($arResult['DISCOUNT'][0]):?>style="border-width: 2px;border-style: solid;border-color: transparent;border-image: url('<?=$arResult['DISCOUNT'][0]["BORDER_IMG"]?>') 100 repeat;"<?endif;?>>
                        <div class="avail">
                            <div class="vendor vendor_style">Артикул <?=$arResult['ID']?></div>
                            <div class="avail-p">
                                <?if(!empty($arResult['PROPERTIES']['PROIZVODITEL']['VALUE'])):?>
                                    <img src="<?=$arResult['PROPERTIES']['PROIZVODITEL']['VALUE']?>" alt="flag">
                                <?endif;?>
                                <span class="avail-v">
                                	<?if($arResult['PRODUCT']['QUANTITY'] > 0):?>
                           		    	В наличии
                           		    <?else:?>
                           		    	Наличие надо уточнить<br/>по телефону
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
                                <?if($arResult['PROPERTIES']['DISCOUNT_VALUE']['VALUE'] > 0):?>
                                        <div class="discount_block">
                                            <div class="disc">
                                                <span><?=$arResult['PRICES']['BASE']['PRINT_VALUE']?></span>
                                                руб.
                                            </div>
                                            <div class="old_price">
                                                <?=substr(CurrencyFormat($arResult['PROPERTIES']['DISCOUNT_VALUE']['VALUE'], "RUS"), 0, -3);?> руб.
                                            </div>
                                            <img src="<?=SITE_TEMPLATE_PATH?>/img/discount_icon.png" alt="img">
                                            <div style="clear: both; width: 100%; padding: 5px 0; border-bottom: 1px solid #f1f3f5;"></div>
                                            <div style="margin-top: 5px;">
                                                Экономия <span style="color: #d50825"><?=substr(CurrencyFormat($arResult['PROPERTIES']['DISCOUNT_VALUE']['VALUE'] - $arResult['PRICES']['BASE']['VALUE'], "RUS"), 0, -3);?> руб.</span>
                                            </div>
                                        </div>
                                    <?else:?>
                                        <span><?=$arResult['PRICES']['BASE']['PRINT_VALUE']?></span>
                                        руб.
                                    <?endif;?>
                            </div>
                            <?if(!isset($arResult['BASKET_PRODUCTS'][$arResult['ID']])):?>
                            	<div class="counter" style="display: none;">
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
                        <?if(!isset($arResult['BASKET_PRODUCTS'][$arResult['ID']])):?>
                        <?if(!empty($arResult['PROPERTIES']['MODIFICATIONS']['FULL_INFO']) && is_array($arResult['PROPERTIES']['MODIFICATIONS']['FULL_INFO'])) {
                            foreach ($arResult['PROPERTIES']['MODIFICATIONS']['FULL_INFO'] as $value) {?>
                                <div class="input radio">
                                    <input type="checkbox" data-modification-id="<?=$value['ID']?>" data-modification-price="<?=$value['PRICE_INFO']['PRICE'];?>" data-product-price="<?=$arResult['PRICES']['BASE']['VALUE']?>" data-product-id="<?=$arResult['ID']?>">
                                    <label>
                                        <span><?=$value['NAME']?></span> + 
                                        <?=CurrencyFormat($value['PRICE_INFO']['PRICE'], 'RUB');?> руб.
                                    </label>
                                </div>
                            <?}
                        }?>
                    <?endif;?>

                    <div style="clear: both;"></div>
                        <?if(!empty($arResult['PROPERTIES']['ORIGINAL_DETAIL']['FULL_INFO']) && is_array($arResult['PROPERTIES']['ORIGINAL_DETAIL']['FULL_INFO'])) {?>
                            <div class="buy-w original-detail">
                            	<div class="title">Это деталь оригинал:</div>
							    <?foreach ($arResult['PROPERTIES']['ORIGINAL_DETAIL']['FULL_INFO'] as $key => $item):?>
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
							</div>
                        <?}?>
                 
                        <div style="clear: both;"></div>
                        <div class="panel-b">
                        	<?if(!isset($arResult['BASKET_PRODUCTS'][$arResult['ID']])):?>
								<a href="javascript:void(0)" class="btn-p btn-c-lilac" data-add-basket="<?=$arResult['ID']?>" data-quantity="1">
                            	    Купить
                            	</a>
							<?else: ?>
								<a href="javascript:void(0)" class="btn-p btn-c-lilac active">
                            	    Добавлено
                            	</a>
							<?endif;?>
                            <?
                                $json = json_encode([
                                    "id" => $arResult["ID"] ?? "",
                                    "name" => $arResult["NAME"] ?? "",
                                    "price" => (int)$arResult["MIN_PRICE"]["VALUE"] ?? "",
                                    "brand" => $arResult["PROPERTIES"][75]["VALUE"] ?? "",
                                    "category" => $arResult["SECTION_NAME"] ?? "",
                                    "quantity" => 1
                                ]);
                            ?>
                            <a href="javascript:;" data-modal="#buy_one_click" data-buy1click-product-id="<?=$arResult['ID']?>" data-byuing1click='<?=$json?>' class="btn-p btn-c-tansp">Купить в 1 клик</a>
                        </div>
                    </div>
                    <div class="add_info mob">
               		    <?if(!isset($arResult['BASKET_PRODUCTS'][$arResult['ID']])):?>
               		        <div class="pan-add">
               		            <div class="input radio">
               		                <input type="checkbox" id="SETTING">
               		                <label for="" style="font-size: 18px; font-weight: bold;">Нужна установка и покраска</label>
               		            </div>
               		        </div>
               		    <?endif;?>
               		</div>
                    <div class="add_info" style="display: none;">
                        <div class="pan-add cr">
                            <a href="#" target="_blank">Читать о доставке</a>
                        </div>
                    </div>
                    <div class="add_info">
                        <!-- <div class="pan-add inst">
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
                        </div> -->
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
                    <div class="slider slider-cart">
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
                <!-- <div class="block-c">
                    <div class="title">Отзывы с Вконтакте</div>
                    <div class="wrap">
                        <?//if(!$USER->IsAdmin()):?>
                            <div id="vk_comments"></div>
                        <?//endif;?>
                    </div>
                </div> -->
                <div class="block-c" style="display: none;">
                    <div class="title">Отзывы с Facebook</div>
                    <div class="wrap">
                        <div class="vk">
                            <img src="<?=SITE_TEMPLATE_PATH?>/img/fb.jpg" alt="img" style="display: none;">
                            <div id="fb-root"></div>
                            <script>(function(d, s, id) {
                              var js, fjs = d.getElementsByTagName(s)[0];
                             if (d.getElementById(id)) return;
                              js = d.createElement(s); js.id = id;
                              js.src = 'https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v3.2';
                              fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));</script>
                            <div class="fb-comments" data-href="<?php echo $APPLICATION->GetCurPage(); ?>" data-numposts="10" data-colorscheme="light" data-width="100%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="cart-sidebar" <?if($arResult['DISCOUNT'][0]):?>style="border-width: 2px;border-style: solid;border-color: transparent;border-image: url('<?=$arResult['DISCOUNT'][0]["BORDER_IMG"]?>') 100 repeat;"<?endif;?>>
                    <div class="avail">
                        <div class="vendor vendor_style">Артикул <?=$arResult['ID']?> <?if($USER->IsAdmin()):?>(<?=$arResult['PROPERTIES']['ARTICLE']['VALUE']?>)<?endif;?></div>
                        <div class="avail-p">
                            <?if(!empty($arResult['PROPERTIES']['PROIZVODITEL']['VALUE'])):?>
                                <img src="<?=$arResult['PROPERTIES']['PROIZVODITEL']['VALUE']?>" alt="flag">
                            <?endif;?>
                            <span class="avail-v">
                                <?if($arResult['PRODUCT']['QUANTITY'] > 0):?>
                                    В наличии
                                <?else:?>
                                    Наличие надо уточнить<br/>по телефону
                                <?endif;?>
                            </span>
                        </div>
                    </div>
                    <div style="clear: both;"></div>
                    <h2><?=$arResult['NAME']?></h2>
                    <div class="descr">
                        <?=$arResult['PREVIEW_TEXT']?>
                    </div>
                    <?if($arResult['PROPERTIES']['IS_MAGNITOLA']['VALUE'] != "Да"):?>
                 		<div class="price-panel">
                 		    <div class="pr">
                 		        <?if($arResult['PROPERTIES']['DISCOUNT_VALUE']['VALUE'] > 0):?>
                 		            <div class="discount_block">
                 		                <div class="disc">
                 		                    <span><?=$arResult['PRICES']['BASE']['PRINT_VALUE']?></span>
                 		                    руб.
                 		                </div>
                 		                <div class="old_price" style="font-size: 16px;">
                 		                    <?=substr(CurrencyFormat($arResult['PROPERTIES']['DISCOUNT_VALUE']['VALUE'], "RUS"), 0, -3);?> руб.
                 		                </div>
                 		                <img src="<?=SITE_TEMPLATE_PATH?>/img/discount_icon.png" alt="img">
                 		                <div style="clear: both; width: 100%; padding: 5px 0; border-bottom: 1px solid #f1f3f5;"></div>
                 		                <div style="margin-top: 5px">
                 		                    Экономия <span style="color: #d50825"><?=substr(CurrencyFormat($arResult['PROPERTIES']['DISCOUNT_VALUE']['VALUE'] - $arResult['PRICES']['BASE']['VALUE'], "RUS"), 0, -3);?> руб.</span>
                 		                </div>
                 		            </div>
                 		        <?else:?>
                 		            <span><?=$arResult['PRICES']['BASE']['PRINT_VALUE']?></span>
                 		            руб.
                 		        <?endif;?>
                 		    </div>
                 		    <?if(!isset($arResult['BASKET_PRODUCTS'][$arResult['ID']])):?>
                 		    	<div class="counter" style="display: none;">
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
                		<?if(!isset($arResult['BASKET_PRODUCTS'][$arResult['ID']])):?>
                		    <?if(!empty($arResult['PROPERTIES']['MODIFICATIONS']['FULL_INFO']) && is_array($arResult['PROPERTIES']['MODIFICATIONS']['FULL_INFO'])) {
                		        foreach ($arResult['PROPERTIES']['MODIFICATIONS']['FULL_INFO'] as $value) {?>
                		            <div class="input radio">
                		                <input type="checkbox" data-modification-id="<?=$value['ID']?>" data-modification-price="<?=$value['PRICE_INFO']['PRICE'];?>" data-product-price="<?=$arResult['PRICES']['BASE']['VALUE']?>" data-product-id="<?=$arResult['ID']?>">
                		                <label>
                		                    <span><?=$value['NAME']?></span> + 
                		                    <?=CurrencyFormat($value['PRICE_INFO']['PRICE'], 'RUB');?> руб.
                		                </label>
                		            </div>
                		        <?}
                		    }?>
                		<?endif;?>
                		<div style="clear: both;"></div>

                		    <?if(!empty($arResult['PROPERTIES']['ORIGINAL_DETAIL']['FULL_INFO']) && is_array($arResult['PROPERTIES']['ORIGINAL_DETAIL']['FULL_INFO'])) {?>
                		        <div class="buy-w original-detail">
                		        	<div class="title">Это деталь оригинал:</div>
								    <?foreach ($arResult['PROPERTIES']['ORIGINAL_DETAIL']['FULL_INFO'] as $key => $item):?>
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
								</div>
                		    <?}?>

                		    <div style="clear: both;"></div>
                		<div class="panel-b">
                		    <?if(!isset($arResult['BASKET_PRODUCTS'][$arResult['ID']])):?>
								<a href="javascript:void(0)" class="btn-p btn-c-lilac" data-add-basket="<?=$arResult['ID']?>" data-quantity="1">
                		    	    Купить
                		    	</a>
							<?else: ?>
								<a href="javascript:void(0)" class="btn-p btn-c-lilac active">
                		    	    Добавлено
                		    	</a>
							<?endif;?>
                		    <a href="" data-modal="#buy_one_click" data-buy1click-product-id="<?=$arResult['ID']?>" data-byuing1click='<?=$json?>' class="btn-p btn-c-tansp">Купить в 1 клик</a>
                		</div>
                	<?else:?>
                			<div class="pricing-block-magnitola">
                				<?if(count($arResult['PROPERTIES']['VERSION']['VALUE']) > 0):?>
                					<div class="list-tab">
                						<div class="title">Версия устройства:</div>
                						<div class="list-tab-wr" data-actual-prop>
                							<?foreach($arResult['PROPERTIES']['VERSION']['VALUE'] as $key => $value):?>
                								<div class="item-tab<?if($key == 0):?> active<?endif;?>" data-code="VERSION" data-name="<?=$arResult['PROPERTIES']['VERSION']["NAME"]?>" data-value="<?=$value?>">
                									<?=$value?>
                								</div>
                							<?endforeach;?>
                						</div>	
                					</div>
                				<?endif;?>

                         		<?if(count($arResult['PROPERTIES']['RAM']['VALUE']) > 0):?>
                         		    <div class="list-tab">
                         		        <div class="title">Оперативная память:</div>
                         		        <div class="list-tab-wr" data-price-prop>
                         		            <?foreach($arResult['PROPERTIES']['RAM']['VALUE'] as $key => $value):?>
                         		                <div class="item-tab<?if($key == 0):?> active<?endif;?>" 
                         		                	data-code="RAM" 
                         		                	data-name="<?=$arResult['PROPERTIES']['RAM']["NAME"]?>" 
                         		                	data-value="<?=$value?>"
                         		                	data-prop-magnitola-id="<?=$arResult['PROPERTIES']['RAM']['FULL_INFO'][$key]['ID']?>" 
                         		                	data-prop-magnitola-price="<?=intval($arResult['PROPERTIES']['RAM']['FULL_INFO'][$key]['PRICE_INFO']['PRICE'])?>"
                         		                	data-prop-magnitola-default-id="<?=$arResult['ID']?>"
                         		                >
                         		                    <?=$arResult['PROPERTIES']['RAM']['FULL_INFO'][$key]["NAME"]?>
                         		                </div>
                         		            <?endforeach;?>
                         		        </div>  
                         		    </div>
                         		<?endif;?>

                				<?if(count($arResult['PROPERTIES']['MAGNITOLA_COMPLECT']['FULL_INFO']) > 0):?>
                					<div class="list-tab">
                						<div class="title">Комплектация:</div>
                						<div class="list-tab-wr-input" data-price-prop>
                							<div class="input radio active" data-complect="<?=$arResult['ID']?>">
                								<label>
                									Стандартная комплектация
                								</label>
                								<input type="radio" name="MAGNITOLA_COMPLECT" data-prop-magnitola-default-id="<?=$arResult['ID']?>" data-prop-magnitola-id="<?=$arResult['ID']?>" data-prop-magnitola-price="<?=intval($arResult['PRICES']['BASE']['VALUE'])?>" checked value="">
                							</div>
                							<?foreach($arResult['PROPERTIES']['MAGNITOLA_COMPLECT']['FULL_INFO'] as $key => $value):?>
                								<div class="input radio" data-complect="<?=$value['ID']?>">
                									<label>
                										<?=$value['NAME']?>
                										<?if(intval($arResult['PRICES']['BASE']['VALUE']) < intval($value['PRICE_INFO']['PRICE'])):?>
                											(+ <?=CurrencyFormat(intval($arResult['PRICES']['BASE']['VALUE']) - intval($value['PRICE_INFO']['PRICE']) , 'RUB');?> руб.)
                										<?else:?>
                											(<?=CurrencyFormat(intval($value['PRICE_INFO']['PRICE']) - intval($arResult['PRICES']['BASE']['VALUE']) , 'RUB');?> руб.)
                										<?endif?>
                									</label>
                									<input type="radio" name="MAGNITOLA_COMPLECT" data-prop-magnitola-default-id="<?=$arResult['ID']?>" data-prop-magnitola-id="<?=$value['ID']?>" data-prop-magnitola-price="<?=intval($value['PRICE_INFO']['PRICE'])?>">
                								</div>
                							<?endforeach;?>
                						</div>	
                					</div>
                         		    <?if($arResult["PROPERTIES"]["STANDART_COMPLECT"]["VALUE"]):?>
                         		        <div class="complect-block active" data-complect-block="<?=$arResult['ID']?>">
                         		            <div class="title">Комплект состоит из:</div>
                         		            <ul>
                         		                <?foreach ($arResult["PROPERTIES"]["STANDART_COMPLECT"]["VALUE"] as $key => $value):?>
                         		                    <li>
                         		                        <span class="icon">
                         		                            <svg width="15" height="11" viewBox="0 0 15 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                         		                                <path d="M1 5.28571L5.66667 9.57143L13.4444 1" stroke="#002E47" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                         		                            </svg>
                         		                        </span>
                         		                        <?=$value?>
                         		                    </li>
                         		                <?endforeach;?>
                         		            </ul>
                         		        </div>
                         		    <?endif;?>
                         		    <?foreach($arResult['PROPERTIES']['MAGNITOLA_COMPLECT']['FULL_INFO'] as $key => $value):?>
                         		        <div class="complect-block" data-complect-block="<?=$value['ID']?>">
                         		            <div class="title">Комплект состоит из:</div>
                         		            <ul>
                         		                <?foreach ($value["PROPERTIES"]["COMPLECTATION"]["VALUE"] as $key => $val):?>
                         		                    <li>
                         		                        <span class="icon">
                         		                            <svg width="15" height="11" viewBox="0 0 15 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                         		                                <path d="M1 5.28571L5.66667 9.57143L13.4444 1" stroke="#002E47" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                         		                            </svg>
                         		                        </span>
                         		                        <?=$val?>
                         		                    </li>
                         		                <?endforeach;?>
                         		            </ul>
                         		        </div>
                         		    <?endforeach;?>
                				<?endif;?>
                				<div class="price-panel price-magnitola-block">
                 				    <div class="pr">
                 				        <span></span>
                 				    </div>
                 				</div>
                         		<div style="clear: both;"></div>
                         		<div class="panel-b">
                         		    <?if(!isset($arResult['BASKET_PRODUCTS'][$arResult['ID']])):?>
                         		        <a href="javascript:void(0)" class="btn-p btn-c-lilac" data-add-basket-magnitola="<?=$arResult['ID']?>">
                         		            Купить
                         		        </a>
                         		    <?else: ?>
                         		        <a href="javascript:void(0)" class="btn-p btn-c-lilac active">
                         		            Добавлено
                         		        </a>
                         		    <?endif;?>
                         		    <!-- <a href="" data-modal="#buy_one_click" data-buy1click-product-id="<?=$arResult['ID']?>" data-byuing1click='<?=$json?>' class="btn-p btn-c-tansp">Купить в 1 клик</a> -->
                         		</div>
                			</div>
                 	<?endif;?>
                </div>
                <div class="add_info" style="display: none;">
                    <div class="pan-add cr">
                        <a href="#" target="_blank">Читать о доставке</a>
                    </div>
                </div>
                <div class="add_info pk">
                    <!-- <div class="pan-add inst">
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
                    </div> -->
                    <?if(!isset($arResult['BASKET_PRODUCTS'][$arResult['ID']])):?>
                        <div class="pan-add">
                            <div class="input radio">
                                <input type="checkbox" id="SETTING">
                                <label for="" style="font-size: 18px; font-weight: bold;">Нужна установка и покраска</label>
                            </div>
                        </div>
                    <?endif;?>
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
<script>
    dataLayer.push({
       "ecommerce": {
           "detail": {
               "products": [
                   {
                       "id": <?=$arResult["ID"] ?? ""?>,
                       "name" : <?=$arResult["NAME"] ?? ""?>,
                       "price": <?=$arResult["MIN_PRICE"]["VALUE"] ?? ""?>
                       "brand": <?=$arResult["PROPERTIES"][75]["VALUE"] ?? ""?>,
                       "category": <?=$arResult["SECTION"]["NAME"] ?? ""?>,
                   }
               ]
           }
       }
    })
</script>