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
$bxajaxid = CAjax::GetComponentID($component->__name, $component->__template->__name, $component->arParams['AJAX_OPTION_ADDITIONAL']);
$page = $APPLICATION->GetCurPage();
//16
global $USER;
$arGroups = [];
if($USER->IsAuthorized()) {
    $arGroups = $USER->GetUserGroupArray();
}
?>
<div class="page cart catalog-b">
    <div class="container">
        <div class="row">
            <div class="title_h1"><?=$arResult['NAME']?></div>
            <div class="sort_panel">
                <div class="wrap">
                    <h2>Каталог продукций</h2>
                    <div class="sort_block">
                        <div class="name_s">Сортировать по</div>
                        <div class="select">
                            <select style="display: none;" class="sort_select">
                                <option value="<?=$APPLICATION->GetCurPageParam("sort=name&order=ASC", array('sort', 'order'));?>">Цена</option>
                                <option value="<?=$APPLICATION->GetCurPageParam("sort=catalog_PRICE_1&order=ASC", array('sort', 'order'));?>">Название</option>
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
                                    <li <?if($_REQUEST['sort'] == 'catalog_PRICE_1'):?>class="active"<?endif;?> data-value="<?=$APPLICATION->GetCurPageParam("sort=catalog_PRICE_1&order=ASC", array('sort', 'order'));?>">Цена</li>
                                    <li <?if($_REQUEST['sort'] == 'name'):?>class="active"<?endif;?> data-value="<?=$APPLICATION->GetCurPageParam("sort=name&order=ASC", array('sort', 'order'));?>">Название</li>
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
            <div class="col-lg-<?=(strpos($page, '/search/')!==false)?12:9;?> cat-block">
                    <?//if($APPLICATION->GetCurPage() == '/cat/'):?>
                        <?foreach ($arResult['ITEMS'] as $section => $i):?>
                    <!-- <div class="cat_b">
                    <div class="name-c">
                        <?=$section?>
                        <span class="b-c">
                            <i class="fas fa-angle-up"></i>
                        </span>
                    </div>
                    <div class="wrap-c"> -->
                        <?foreach ($i as $item)
                            {
                                $uniqueId = $item['ID'].'_'.md5($this->randString().$component->getAction());
                                $this->AddEditAction($uniqueId, $item['EDIT_LINK'], $elementEdit);
                                $this->AddDeleteAction($uniqueId, $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);
                                if($USER->IsAdmin()) {
                                    //echo "<pre>";
                                    //print_r($item);
                                    //echo "</pre>";
                                }
                            ?>
                        <div class="product-block" id="<? echo $this->GetEditAreaId($uniqueId); ?>">
                            <div class="wrap" <?if($item['DISCOUNT'][0]):?>style="border-image: url('<?=$item['DISCOUNT'][0]["BORDER_IMG"]?>') 100 repeat;"<?endif;?>>
                                    <div class="discount-img-block tt">
                                        <?foreach ($item['DISCOUNT'] as $key => $dis):
                                            $style = '';
                                            if(isset($dis["STYLES"])) {
                                                foreach ($dis["STYLES"] as $n => $v) {
                                                    $style .= "{$n}: {$v};";
                                                }
                                            }
                                        ?>
                                            <img src="<?=$dis["ICON"]?>" alt="" style="width: <?=$dis["WIDTH"] ? $dis["WIDTH"] : 'auto' ?>; height: <?=$dis["HEIGHT"] ? $dis["HEIGHT"] : 'auto' ?>;<?=$style?>">
                                        <?endforeach;?>
                                    </div>
                                <div class="img">
                                    <a href="<?=$item['DETAIL_PAGE_URL']?>">
                                        <img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt="image">
                                    </a>
                                </div>
                                <div class="art">
                                    <?if(!empty($item['PROPERTIES']['PROIZVODITEL']['VALUE'])):?>
                                        <img src="<?=$item['PROPERTIES']['PROIZVODITEL']['VALUE']?>" alt="flag">
                                    <?endif;?>
                                    <span class="art mobile">Арт. <?=$item['ID']?><?if($USER->IsAdmin()):?>  (<?=$item['PROPERTIES']['ARTICLE']['VALUE']?>)<?endif;?></span>
									<span class="art desktop">Артикул <?=$item['ID']?><?if($USER->IsAdmin()):?>  (<?=$item['PROPERTIES']['ARTICLE']['VALUE']?>)<?endif;?></span>
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
                                <?
                                    $json = json_encode([
                                        "id" => $item["ID"] ?? "",
                                        "name" => $item["NAME"] ?? "",
                                        "price" => (int)$item["MIN_PRICE"]["VALUE"] ?? "",
                                        "brand" => $item["PROPERTIES"][75]["VALUE"] ?? "",
                                        "category" => $item["SECTION_NAME"] ?? "",
                                        "quantity" => 1
                                    ]);
                                ?>
                                <div class="bottom_pr_panel" <?if($item['DISCOUNT'][0]):?>style="border-image: url('<?=$item['DISCOUNT'][0]["BORDER_IMG"]?>') 100 repeat;"<?endif;?>>
                                    <button type="button" data-modal="#buy_one_click" data-buy1click-product-id="<?=$item['ID']?>" data-byuing1click='<?=$json?>' class="btn-product-one-click">Купить в 1 клик</button>
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
                        </div>
                        <?}?>
                    <!-- </div>
                    </div> -->
                    <?endforeach;?>
                    <?//endif;?>     
                <?
                	if($USER->IsAdmin()) {
                		//print_r($_REQUEST);
                	}
                    // if ($arParams["DISPLAY_BOTTOM_PAGER"] && $arParams['PAGE_ELEMENT_COUNT'] == count($arResult['ITEMS']))
                    // {
                    //     echo $arResult["NAV_STRING"];
                    // }
                ?>
            </div>
            <?echo $arResult["NAV_STRING"];?>
            <?/*if($arResult['NAV_RESULT']->nEndPage > 1):?>

                <?if (intval($arResult['NAV_RESULT']->NavPageNomer) + 1 <= $arResult['NAV_RESULT']->nEndPage):?>
            
                    <div class="load_more<?=$bxajaxid?>" data-ajax-id="<?=$bxajaxid?>" data-current-page="<?=$arResult['NAV_RESULT']->NavPageNomer?>" data-url="<?=$APPLICATION->GetCurPageParam("", array("PAGEN_".$arResult['NAV_RESULT']->NavNum))?>">
                    </div>

                <?endif?>
            
            <?endif*/?>
        </div>
    </div>
</div>