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
?>

						<?foreach ($arResult['ITEMS'] as $item)
							{
								$uniqueId = $item['ID'].'_'.md5($this->randString().$component->getAction());
								$this->AddEditAction($uniqueId, $item['EDIT_LINK'], $elementEdit);
								$this->AddDeleteAction($uniqueId, $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);
							?>
                    	<div class="product-block" id="<? echo $this->GetEditAreaId($uniqueId); ?>">
							<div class="wrap">
								<div class="img">
									<a href="<?=$item['DETAIL_PAGE_URL']?>">
										<img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt="image">
									</a>
								</div>
								<div class="art">
									<?if(!empty($item['PROPERTIES']['PROIZVODITEL']['VALUE'])):?>
                                    	<img src="<?=$item['PROPERTIES']['PROIZVODITEL']['VALUE']?>" alt="flag">
                                    <?endif;?>
                                    <span class="art">Арт. <?=$item['ID']?></span>
                                    
                                </div>
								<div class="name">
									<a href="<?=$item['DETAIL_PAGE_URL']?>">
										<?=$item['NAME']?>
									</a>
								</div>
								<div class="price">
                                    <?if($item['PROPERTIES']['DISCOUNT_VALUE']['VALUE'] > 0):?>
                                        <div class="discount_block">
                                            <div class="disc">
                                                <span><?=$item['PRICES']['BASE']['PRINT_VALUE_NOVAT']?></span>
                                                руб.
                                            </div>
                                            <div class="old_price">
                                                <?=substr(CurrencyFormat($item['PROPERTIES']['DISCOUNT_VALUE']['VALUE'], "RUS"), 0, -3);?> руб.
                                            </div>
                                            <img src="<?=SITE_TEMPLATE_PATH?>/img/discount_icon.png" alt="img">
                                        </div>
                                    <?else:?>
                                        <span><?=$item['PRICES']['BASE']['PRINT_VALUE_NOVAT']?></span>
                                        руб.
                                    <?endif;?>
                                </div>
								<button type="button" data-modal="#buy_one_click" data-buy1click-product-id="<?=$item['ID']?>" class="btn-product-one-click">Купить в 1 клик</button>
								<?if(!isset($arResult['BASKET_PRODUCTS'][$item['ID']])):?>
									<?if($item['PROPERTIES']['IS_MAGNITOLA']['VALUE'] != "Да"):?>
                                        <button type="button" data-add-basket="<?=$item['ID']?>" onclick='addingEcommerce(<?=$json?>)' data-quantity="1" class="btn-product">
                                            <span class="icon"></span>
                                            Купить
                                        </button>
                                    <?else:?>
                                        <a type="button" href="<?=$item['DETAIL_PAGE_URL']?>" class="btn-product">
                                            <span class="icon"></span>
                                            Купить
                                        </a>
                                    <?endif;?>
								<?else: ?>
									<button type="button" class="btn-product active">
										<span class="icon"></span>
										Добавлено
									</button>
								<?endif;?>
							</div>
						</div>
						<?}?>
                <?
                    if ($arParams["DISPLAY_BOTTOM_PAGER"] && $arParams['PAGE_ELEMENT_COUNT'] == count($arResult['ITEMS']))
                    {
                        echo $arResult["NAV_STRING"];
                    }
                ?>
<?if(empty($arResult['ITEMS'])):?>
    <h2>К сожалению товары не найдены</h2>
<?endif;?>
