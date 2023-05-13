<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 * @var CMain $APPLICATION
 * @var CBitrixBasketComponent $component
 * @var CBitrixComponentTemplate $this
 * @var array $giftParameters
 */

$displayModeClass = $arParams['DISPLAY_MODE'] === 'compact' ? ' basket-items-list-wrapper-compact' : '';
global $FILTER_LOST, $USER;
?>
<form action="" id="basket_form"><input type="submit" value=""></form>
<div id="basket_det"></div>
<div class="page cart basket-c">
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
			<h1 style="margin-top: 20px;">Корзина</h1>
<?
if (empty($arResult['ERROR_MESSAGE']))
{
	?>
			<div class="basket" id="buy_order_basket">
				<div class="wr">
					<?foreach ($arResult['ITEMS'] as $st => $keys):?>
						<?foreach ($keys as $key => $basket):
							$ifMagnitola = false;
							$magnitolProps = [];

							$db_res = CSaleBasket::GetPropsList(
							    array(
							            "SORT" => "ASC",
							            "NAME" => "ASC"
							        ),
							    array(
							    	"BASKET_ID" => $basket['ID'],
							    	"NAME"		=> 'MODIFICATION'
							    )
							);
							if ($ar_res = $db_res->Fetch())
							{
							   continue;
							}

							$exist = false;

							if(is_array($basket['PROPS'])) {
								foreach($basket['PROPS'] as $prop) {
									if($prop['CODE'] == 'MAGNITOLA')
										$ifMagnitola = true;

									if($prop['CODE'] == 'DEFAULT_PRODUCT')
										$exist = true;

									if($prop['CODE'] == 'MAGNITOLA_PROPS') {
										$val = json_decode($prop['~VALUE']);

										if(is_array($val)) {
											$magnitolProps = $val;
										}
									}
								}
							}

							if($exist) 
								continue;


						?>
							<div class="basket_produсt item-<?=$basket['ID'];?>">
									<div class="img">
										<a href="<?=$basket['DETAIL_PAGE_URL']?>">
											<?if(!empty($basket['PREVIEW_PICTURE_SRC'])):?>
												<img src="<?=$basket['PREVIEW_PICTURE_SRC']?>" alt="img">
											<?endif;?>
										</a>
									</div>
									<div class="middle">
										<div class="left">
											<div class="art">
												Арт:
												<span><?=$basket['PRODUCT_ID']?></span>
											</div>
											<div class="name">
												<a href="<?=$basket['DETAIL_PAGE_URL']?>">
													<?=$basket['NAME']?>
												</a>
												<?if(count($basket['MAGNITOLA_PROPS']) > 0):?>
													<ul>
														<?foreach ($basket['MAGNITOLA_PROPS'] as $ii => $value):
															if($ii == $value['ID']) continue;
														?>
                         		                    		<li>
                         		                        	<span class="icon">
                         		                            	<svg width="15" height="11" viewBox="0 0 15 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                         		                                	<path d="M1 5.28571L5.66667 9.57143L13.4444 1" stroke="#002E47" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                         		                            	</svg>
                         		                        	</span>
                         		                        	<?=$value['NAME']?> (<span><?=$value['SUM']?></span> руб.)
                         		                    		</li>
                         		                		<?endforeach;?>
                         		                		<?foreach($magnitolProps as $value):?>
                         		                			<?if(is_object($value) && isset($value->VALUE)):?>
                         		                				<li>
                         		                					<span class="icon">
                         		                        				<svg width="15" height="11" viewBox="0 0 15 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                         		                        			    	<path d="M1 5.28571L5.66667 9.57143L13.4444 1" stroke="#002E47" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                         		                        				</svg>
                         		                        			</span>
                         		                					<?=$value->VALUE?>
                         		                				</li>
                         		                			<?endif;?>
                         		                		<?endforeach;?>
													</ul>
												<?endif;?>
											</div>
										</div>
										<div class="bl-basket">
											<div class="price">
												<span><?=$basket['SUM']?></span>
												руб.
											</div>
											<?if(!$ifMagnitola):?>
												<div class="counter">
													<span class="btn-counter minus" data-in-basket="<?=$basket['PRODUCT_ID'];?>"> <i class="fas fa-minus"></i>
													</span>
													<input type="number" class="value" value="<?=$basket['QUANTITY']?>">
													<span class="btn-counter plus" data-in-basket="<?=$basket['PRODUCT_ID'];?>"> <i class="fas fa-plus"></i>
													</span>
												</div>
											<?else:?>
												<strong style="font-size: 16px; width: 150px; height: 52px; display: flex; align-items: center; justify-content: center;">
													<?=$basket['QUANTITY']?>
												</strong>
											<?endif;?>
										</div>
										<div class="btn-c">
											<a href="javascript:void(0)" data-remove="<?=$basket['ID'];?>" data-ecommerce='<?=json_encode(["id" => $basket['ID'] ,"name" => $basket['NAME']])?>' class="cansel">
												<i class="fas fa-times"></i>
											</a>
										</div>
									</div>
									<div class="add_p" style="display: none;">
										<div class="block-bas-product">
											<div class="input checkbox">
												<input type="checkbox">
											</div>
											<label>
												Купить с покраской -
												<span>4 900 рублей.</span>
											</label>
										</div>
									</div>
								</div>
						<?endforeach;?>
					<?endforeach;?>
				</div>
				
				<div class="basket_panel">
					<div class="total_count">
						<?if($USER->IsAdmin()):?>
							<div class="promocode-block">
								<input type="text" placeholder="Введите промокод" id="promo-block">
								<button type="button" class="btn-product">
            			            Применить
            			        </button>
							</div>
							<?if(count($arResult['COUPON_LIST']) > 0):?>
								<div class="discount-block">
									<?foreach($arResult['COUPON_LIST'] as $discount):?>
										<?if($discount['JS_STATUS'] == 'BAD' || $discount['JS_STATUS'] == 'APPLYED'):?>
											<div class="discount-item<?if($discount['JS_STATUS'] == 'APPLYED'):?> success<?else:?> bad<?endif;?>">
												<span><?=$discount['COUPON']?></span>
											</div>
										<?endif;?>
									<?endforeach;?>
								</div>
							<?endif;?>
						<?endif;?>

						
						
						Итого: <span><?=$arResult['allSum_FORMATED']?></span>
						руб.
					</div>
					<a href="<?if($FILTER_LOST['CAR']['ID']>0):?>/cat/<?else:?>/catalog/<?endif;?>" class="btn-tr-o">Продолжить покупки</a>
					<a href="<?=$arParams['PATH_TO_ORDER']?>" class="btn-tr-o lil">Оформить заказ</a>
				</div>
				<?//if($USER->IsAdmin()):?>
					<h2 style="padding: 15px 0;font-size: 20px;font-family: MullerBold;">Возможно вам может понадобиться</h2>
					<?
						global $arrFilter;
						$arrFilter['ID'] = $arResult['AKSESSUAR'];
					?>
					<?$APPLICATION->IncludeComponent(
						"bitrix:catalog.section", 
						"basket_items", 
						array(
							"ACTION_VARIABLE" => "action",
							"ADD_PROPERTIES_TO_BASKET" => "Y",
							"ADD_SECTIONS_CHAIN" => "N",
							"ADD_TO_BASKET_ACTION" => "ADD",
							"AJAX_MODE" => "N",
							"AJAX_OPTION_ADDITIONAL" => "",
							"AJAX_OPTION_HISTORY" => "N",
							"AJAX_OPTION_JUMP" => "N",
							"AJAX_OPTION_STYLE" => "Y",
							"BACKGROUND_IMAGE" => "-",
							"BASKET_URL" => "/personal/basket.php",
							"BROWSER_TITLE" => "-",
							"CACHE_FILTER" => "N",
							"CACHE_GROUPS" => "Y",
							"CACHE_TIME" => "36000000",
							"CACHE_TYPE" => "A",
							"COMPATIBLE_MODE" => "Y",
							"CONVERT_CURRENCY" => "N",
							"DETAIL_URL" => "",
							"DISABLE_INIT_JS_IN_COMPONENT" => "N",
							"DISPLAY_BOTTOM_PAGER" => "Y",
							"DISPLAY_COMPARE" => "N",
							"DISPLAY_TOP_PAGER" => "N",
							"ELEMENT_SORT_FIELD" => "sort",
							"ELEMENT_SORT_FIELD2" => "id",
							"ELEMENT_SORT_ORDER" => "asc",
							"ELEMENT_SORT_ORDER2" => "desc",
							"FILTER_NAME" => "arrFilter",
							"HIDE_NOT_AVAILABLE" => "N",
							"HIDE_NOT_AVAILABLE_OFFERS" => "N",
							"IBLOCK_ID" => "4",
							"IBLOCK_TYPE" => "catalog",
							"INCLUDE_SUBSECTIONS" => "Y",
							"LINE_ELEMENT_COUNT" => "3",
							"MESSAGE_404" => "",
							"MESS_BTN_ADD_TO_BASKET" => "В корзину",
							"MESS_BTN_BUY" => "Купить",
							"MESS_BTN_DETAIL" => "Подробнее",
							"MESS_BTN_SUBSCRIBE" => "Подписаться",
							"MESS_NOT_AVAILABLE" => "Нет в наличии",
							"META_DESCRIPTION" => "-",
							"META_KEYWORDS" => "-",
							"OFFERS_LIMIT" => "5",
							"PAGER_BASE_LINK_ENABLE" => "N",
							"PAGER_DESC_NUMBERING" => "N",
							"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
							"PAGER_SHOW_ALL" => "N",
							"PAGER_SHOW_ALWAYS" => "N",
							"PAGER_TEMPLATE" => ".default",
							"PAGER_TITLE" => "Товары",
							"PAGE_ELEMENT_COUNT" => "4",
							"PARTIAL_PRODUCT_PROPERTIES" => "N",
							"PRICE_CODE" => array(
								0 => "BASE",
							),
							"PRICE_VAT_INCLUDE" => "Y",
							"PRODUCT_ID_VARIABLE" => "id",
							"PRODUCT_PROPERTIES" => array(
							),
							"PRODUCT_PROPS_VARIABLE" => "prop",
							"PRODUCT_QUANTITY_VARIABLE" => "quantity",
							"PRODUCT_SUBSCRIPTION" => "N",
							"PROPERTY_CODE" => array(
								0 => "",
								1 => "",
							),
							"SECTION_CODE" => "",
							"SECTION_ID" => $_REQUEST["SECTION_ID"],
							"SECTION_ID_VARIABLE" => "SECTION_ID",
							"SECTION_URL" => "",
							"SECTION_USER_FIELDS" => array(
								0 => "",
								1 => "",
							),
							"SEF_MODE" => "N",
							"SET_BROWSER_TITLE" => "Y",
							"SET_LAST_MODIFIED" => "N",
							"SET_META_DESCRIPTION" => "Y",
							"SET_META_KEYWORDS" => "Y",
							"SET_STATUS_404" => "N",
							"SET_TITLE" => "Y",
							"SHOW_404" => "N",
							"SHOW_ALL_WO_SECTION" => "Y",
							"SHOW_CLOSE_POPUP" => "N",
							"SHOW_DISCOUNT_PERCENT" => "N",
							"SHOW_OLD_PRICE" => "N",
							"SHOW_PRICE_COUNT" => "1",
							"TEMPLATE_THEME" => "blue",
							"USE_MAIN_ELEMENT_SECTION" => "N",
							"USE_PRICE_COUNT" => "N",
							"USE_PRODUCT_QUANTITY" => "N",
							"COMPONENT_TEMPLATE" => "basket_items",
							"CUSTOM_FILTER" => "",
							"ADD_PICT_PROP" => "-",
							"LABEL_PROP" => "-",
							"MESS_BTN_COMPARE" => "Сравнить"
						),
						false
					);?>
				<?//endif;?>
			</div>
	<?
}
else
{
	?>
	<div class="about">
		<h1 style="padding: 0;"><?ShowError($arResult['ERROR_MESSAGE']);?></h1>
		<a href="<?if($FILTER_LOST['CAR']['ID']>0):?>/cat/<?else:?>/catalog/<?endif;?>" class="btn-applic">Перейти в каталог</a>
	</div>
		<?
}?>
		</div>
	</div>
</div>