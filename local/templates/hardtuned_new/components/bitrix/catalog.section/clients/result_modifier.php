<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

CModule::IncludeModule("sale");

foreach ($arResult['ITEMS'] as $key => $item) {
	if(empty($item['PREVIEW_PICTURE']['ID'])) {
		unset($arResult['ITEMS'][$key]);
		continue;
	}
	$file = CFile::ResizeImageGet($item['PREVIEW_PICTURE']['ID'], array('width'=>150, 'height'=>150), BX_RESIZE_IMAGE_EXACT);
	$arResult['ITEMS'][$key]['PREVIEW_PICTURE']['SRC'] = $file['src'];
}

$dbBasketItems = CSaleBasket::GetList(
    array(
            "NAME" => "ASC",
            "ID" => "ASC"
        ),
    array(
            "FUSER_ID" => CSaleBasket::GetBasketUserID(),
            "LID" => SITE_ID,
            "ORDER_ID" => "NULL"
        ),
    false,
    false,
    array("PRODUCT_ID", "QUANTITY")
);
while ($arItems = $dbBasketItems->Fetch())
{
	$arResult['BASKET_PRODUCTS'][$arItems["PRODUCT_ID"]] = $arItems;
}