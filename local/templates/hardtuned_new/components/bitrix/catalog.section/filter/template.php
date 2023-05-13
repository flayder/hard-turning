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
<div class="page cart catalog-b">
    <div class="container">
        <div class="row">
            <!-- <?if(!empty($arResult['SECTIONS'])):?>
            <div class="section_b">
                <div class="wrap">
                    <ul>
                        <?foreach ($arResult['SECTIONS'] as $key => $section):?>
                            <li>
                                <a href="<?=$section['SECTION_PAGE_URL']?>"<?if($section['SECTION_PAGE_URL'] == $APPLICATION->GetCurPage()) echo " class='selected'";?>><?=$section['NAME']?></a>
                            </li>
                        <?endforeach;?>
                    </ul>
                </div>
            </div>
            <?endif;?> -->
            <?$APPLICATION->ShowViewContent('list_area');?>
            
            <?$APPLICATION->IncludeComponent(
				"bitrix:breadcrumb",
				"breadcrump_new",
				Array(
					"PATH" => "",
					"SITE_ID" => "s1",
					"START_FROM" => "0"
				)
			);?>
            <h1><?=$arResult['NAME']?></h1>
            <div class="sort_panel">
                <div class="wrap">
                    <h2>Каталог продукций</h2>
                    <div class="sort_block">
                        <div class="name_s">Сортировать по</div>
                        <div class="select">
                            <select style="display: none;" class="sort_select">
                                <option value="<?=$arResult["SECTION_PAGE_URL"]?>?sort=name&order=ASC">Цена</option>
                                <option value="<?=$arResult["SECTION_PAGE_URL"]?>?sort=catalog_PRICE_1&order=ASC">Название</option>
                            </select>
                            <div class="pan">
                                <?if($_REQUEST['sort'] == 'name'):?>
                                    <span class="val">Название</span>
                                <?elseif ($_REQUEST['sort'] == 'catalog_PRICE_1'):?>
                                    <span class="val">Цена</span>
                                <?else:?>
                                    <span class="val">Цена</span>
                                <?endif;?>
                                <i class="fas fa-chevron-down"></i>
                                <ul>
                                    <li <?if($_REQUEST['sort'] == 'catalog_PRICE_1'):?>class="active"<?endif;?> data-value="<?=$arResult["SECTION_PAGE_URL"]?>?sort=catalog_PRICE_1&order=ASC">Цена</li>
                                    <li <?if($_REQUEST['sort'] == 'name'):?>class="active"<?endif;?> data-value="<?=$arResult["SECTION_PAGE_URL"]?>?sort=name&order=ASC">Название</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="filter_mobile">
                <div class="wrap">
                    Фильтры
                    <i class="fas fa-angle-down"></i>
                </div>
            </div>
            <?$APPLICATION->ShowViewContent('filter_area');?>
            <div class="col-lg-9 cat-block">
            	<?if(!empty($arResult['ITEMS'])):?>
                        <?foreach ($arResult['ITEMS'] as $section => $i):?>

						<?foreach ($i as $item)
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
                                <div class="bottom_pr_panel">
								<button type="button" data-modal="#buy_one_click" data-buy1click-product-id="<?=$item['ID']?>" class="btn-product-one-click">Купить в 1 клик</button>
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
						<?}?>

                    <?endforeach;?>
                <?endif;?>
                <?if($arResult['NAV_RESULT']->nEndPage > 1):?>

                <?if (intval($arResult['NAV_RESULT']->NavPageNomer) + 1 <= $arResult['NAV_RESULT']->nEndPage):?>
            
                    <div class="load_more<?=$bxajaxid?>" data-ajax-id="<?=$bxajaxid?>" data-current-page="<?=$arResult['NAV_RESULT']->NavPageNomer?>" data-url="<?=$APPLICATION->GetCurPageParam("", array("PAGEN_".$arResult['NAV_RESULT']->NavNum))?>">
                    </div>

                <?endif?>
            
            <?endif?>
            </div>
        </div>
        
    </div>
</div>