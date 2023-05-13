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
$page = $APPLICATION->GetCurPage();
global $USER;
?>

<div class="page cart catalog-b">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 cat-block cat-basket">
                    <?//if($APPLICATION->GetCurPage() == '/cat/'):?>
                        <?foreach ($arResult['ITEMS'] as $section => $item):
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
                                    <div class="discount_block">
                                        <?
                                            //print_r($item['PRICES']['BASE']);
                                            $price = $item['PRICES']['BASE']['VALUE_VAT'] + $item['PRICES']['BASE']['VALUE_VAT']*0.05;

                                        ?>
                                        <div class="disc">
                                            <span><?=$item['PRICES']['BASE']['PRINT_VALUE_NOVAT']?></span>
                                            руб.
                                        </div>
                                        <div class="old_price">
                                            <?=substr(CurrencyFormat($price, "RUS"), 0, -3);?> руб.
                                        </div>
                                        <img src="<?=SITE_TEMPLATE_PATH?>/img/discount_icon.png" alt="img">
                                    </div>
                                </div>
                                <?
                                    $json = json_encode([
                                        "id" => $item["ID"] ?? "",
                                        "name" => $item["NAME"] ?? "",
                                        "price" => $item["MIN_PRICE"]["VALUE"] ?? "",
                                        "brand" => $item["PROPERTIES"][75]["VALUE"] ?? "",
                                        "category" => $item["SECTION_NAME"] ?? "",
                                        "quantity" => 1
                                    ]);
                                ?>
                                <div class="bottom_pr_panel">
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
                    <?endforeach;?>
                    <?//endif;?>
                
                <?
                    if ($arParams["DISPLAY_BOTTOM_PAGER"] && $arParams['PAGE_ELEMENT_COUNT'] == count($arResult['ITEMS']))
                    {
                        echo $arResult["NAV_STRING"];
                    }
                ?>
            </div>
        </div>
    </div>
</div>