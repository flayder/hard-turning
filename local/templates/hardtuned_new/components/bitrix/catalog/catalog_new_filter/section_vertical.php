<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
global ${$arParams["FILTER_NAME"]}, $FILTER_LOST, $USER;
$arParams['IBLOCK_ID'] = 4;
$arParams['IBLOCK_TYPE'] = 'catalog';
$SECTION_ID = '';
$filterParam = false;
$filterSec = false;
$description = '';

function page_404() {
	define("PATH_TO_404", "/404.php");
	global $APPLICATION;
	$APPLICATION->RestartBuffer();
	CHTTP::SetStatus("404 Not Found");
	include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/header.php");
	include($_SERVER["DOCUMENT_ROOT"].PATH_TO_404);
	exit();
}

if(!empty($FILTER_LOST['CAR']['ID']) && empty($FILTER_LOST['PAGE_CODE']) && !isset($_REQUEST['all'])) {
	${$arParams["FILTER_NAME"]}['PROPERTY_SECTION_FILTER'] = $FILTER_LOST['CAR']['ID'];
	if(!empty($FILTER_LOST['CAR']['MODEL']['NAME'])) $APPLICATION->AddChainItem('Каталог для '.$FILTER_LOST['CAR']['MARK']['NAME'] . ' ' . $FILTER_LOST['CAR']['MODEL']['NAME'] . ' (' . $FILTER_LOST['CAR']['NAME'] . ')', "/cat/");
	$res = CIBlockSection::GetList(Array("SORT"=>"ASC"), Array('IBLOCK_ID' => 6, 'ID' => $FILTER_LOST['CAR']['ID'], '=CODE' => $FILTER_LOST['PAGE_CODE']), false, Array('UF_CAT_SECTION'));
	if($ar_res = $res->GetNext()) {
		CHTTP::SetStatus('200 OK');
	  	$description = $ar_res['DESCRIPTION'];
	} else {
		page_404();
	}
} elseif(!empty($FILTER_LOST['PAGE_CODE']) && !isset($_REQUEST['all'])) {
	if(strpos($FILTER_LOST['PAGE_CODE'], '?') !== false) {
		$FILTER_LOST['PAGE_CODE'] = substr($FILTER_LOST['PAGE_CODE'], 0, strpos($FILTER_LOST['PAGE_CODE'], '?'));
	}
	$res = CIBlockSection::GetList(Array("SORT"=>"ASC"), Array('IBLOCK_ID' => 6, '=CODE' => $FILTER_LOST['PAGE_CODE']), false, Array('UF_CAT_SECTION'));
	if($ar_res = $res->GetNext()) {
		$SECTION_ID = $ar_res['ID'];
		${$arParams["FILTER_NAME"]}['PROPERTY_SECTION_FILTER'] = $ar_res['ID'];
		$description = $ar_res['DESCRIPTION'];
		$filterParam = $ar_res['ID'];
		if(!empty($FILTER_LOST['CAR']['MODEL']['NAME'])) $APPLICATION->AddChainItem('Каталог для '.$ar_res['NAME'], $ar_res['SECTION_PAGE_URL']);
		$APPLICATION->AddChainItem($ar_res['NAME'], "");
		// if(empty($_SESSION['U_MARKA']) && $ar_res['DEPTH_LEVEL'] == 1) {
		// 	$_SESSION['U_MARKA'] = $ar_res['ID'];
		// 	localRedirect($APPLICATION->GetCurPage());
		// }
		// if(empty($_SESSION['U_MODEL']) && $ar_res['DEPTH_LEVEL'] == 2) {
		// 	$_SESSION['U_MODEL'] = $ar_res['ID'];
		// 	localRedirect($APPLICATION->GetCurPage());
		// }
		// if(empty($_SESSION['U_YEAR']) && $ar_res['DEPTH_LEVEL'] == 3) {
		// 	$_SESSION['U_YEAR'] = $ar_res['ID'];
		// 	localRedirect($APPLICATION->GetCurPage());
		// }
		if(!empty($_SESSION['U_MARKA']) 
			&& !empty($_SESSION['U_MODEL']) 
			&& !empty($_SESSION['U_YEAR']) 
			//&& $USER->IsAuthorized() 
			&& empty($FILTER_LOST['USER']['UF_MAIN_CAR'])
		) {
			localRedirect($APPLICATION->GetCurPage().'?default=car');
		}
		CHTTP::SetStatus('200 OK');
	} else {
		page_404();
	}
} elseif(!empty($FILTER_LOST['PAGE_CODE']) && isset($_REQUEST['all'])) {
	$res = CIBlockSection::GetList(Array("SORT"=>"ASC"), Array('IBLOCK_ID' => 4, '=CODE' => $FILTER_LOST['PAGE_CODE']), false, Array('ID'));
	if($ar_res = $res->GetNext())
		$filterSec = $ar_res['ID'];

	${$arParams["FILTER_NAME"]}['SECTION_CODE'] = $FILTER_LOST['PAGE_CODE'];
}
if(!empty($_SESSION['U_MARKA']) && !empty($_SESSION['U_MODEL']) && !empty($_SESSION['U_YEAR'])) {?>
	<style>
		.title_h {display: none;}
	</style>
<?
}
?>

<?
/*$arSelect = Array("ID", "NAME");
$arFilter = Array("IBLOCK_ID"=>4, "SECTION_ID"=>$arCurSection['ID'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
 $arFields_items = $ob->GetFields();
}*/
?>
<?
if(!empty($SECTION_ID) || !empty($FILTER_LOST['CAR']['ID'])) {
	$this->SetViewTarget("list_area");?>
	<div style="width: 100%; margin-top: 20px;"></div>
	<?
		$APPLICATION->IncludeComponent(
			"bitrix:catalog.section.list",
			"",
			array(
				"IBLOCK_ID" => 6,
				"SECTION_ID" => (!empty($SECTION_ID))?$SECTION_ID:$FILTER_LOST['CAR']['ID'],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
				"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
				"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
				"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
				"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
				"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
				"ADD_SECTIONS_CHAIN" => 'N'
			),
			$component,
			array("HIDE_ICONS" => "Y")
		);
	$this->EndViewTarget("list_area");
}
?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.smart.filter",
		"smartfilter",
		Array(
			"CACHE_GROUPS" => "Y",
			"CACHE_TIME" => "36000000",
			"CACHE_TYPE" => "A",
			"COMPONENT_TEMPLATE" => "smartfilter",
			"CONVERT_CURRENCY" => "N",
			"DISPLAY_ELEMENT_COUNT" => "Y",
			"FILTER_NAME" => $arParams["FILTER_NAME"],
			"FILTER_VIEW_MODE" => "vertical",
			"HIDE_NOT_AVAILABLE" => "N",
			"IBLOCK_ID" => "4",
			"IBLOCK_TYPE" => "catalog",
			"INSTANT_RELOAD" => "N",
			"PAGER_PARAMS_NAME" => "arrPager",
			"POPUP_POSITION" => "left",
			"PRICE_CODE" => array(0=>"BASE"),
			"SAVE_IN_SESSION" => "N",
			"SECTION_ID" => $filterSec,
			"SECTION_CODE" => "",
			"SECTION_DESCRIPTION" => "-",
			"SECTION_TITLE" => "-",
			"SEF_MODE" => "N",
			"TEMPLATE_THEME" => "blue",
			"XML_EXPORT" => "N",
			"PROPERTY_SECTION_FILTER" => $filterParam
		)
	);

	?>
<div class="page cart">
	<div class="container">
		<div class="row"><?
	if($arParams["USE_COMPARE"]=="Y")
	{
		?><?/*$APPLICATION->IncludeComponent(
			"bitrix:catalog.compare.list",
			"",
			array(
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"NAME" => $arParams["COMPARE_NAME"],
				"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
				"COMPARE_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["compare"],
				"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
				"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
				'POSITION_FIXED' => isset($arParams['COMPARE_POSITION_FIXED']) ? $arParams['COMPARE_POSITION_FIXED'] : '',
				'POSITION' => isset($arParams['COMPARE_POSITION']) ? $arParams['COMPARE_POSITION'] : ''
			),
			$component,
			array("HIDE_ICONS" => "Y")
		);*/?><?
	}

	if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y')
	{
		$basketAction = (isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? $arParams['COMMON_ADD_TO_BASKET_ACTION'] : '');
	}
	else
	{
		$basketAction = (isset($arParams['SECTION_ADD_TO_BASKET_ACTION']) ? $arParams['SECTION_ADD_TO_BASKET_ACTION'] : '');
	}
	$intSectionID = 0;
	?>

<?
if (isset($_GET["sort"])) {
	$arParams["ELEMENT_SORT_FIELD"] = $_GET["sort"];
	$arParams["ELEMENT_SORT_ORDER"]= $_GET["order"];
}
if(!empty(${$arParams["FILTER_NAME"]}['PROPERTY_SECTION_FILTER'])){

	$arParams["ELEMENT_SORT_FIELD"] = 'PROPERTY_'.${$arParams["FILTER_NAME"]}['PROPERTY_SECTION_FILTER'];
	$arParams["ELEMENT_SORT_FIELD2"] = 'IBLOCK_SECTION_ID';
}
session_start();

if(isset($_GET['per_page'])):
	$value = intval($_GET['per_page']);
	setcookie("per_page", $value,time()+3600);
	$_COOKIE['per_page']=intval($_GET['per_page']);
endif;

if($_COOKIE['per_page']==''):$_COOKIE['per_page']=100;endif;

?>
	<?$intSectionID = $APPLICATION->IncludeComponent(
		"bitrix:catalog.section",
		"filter",
		array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"SHOW_ALL_WO_SECTION" => "Y",
			"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
			"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
			"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
			"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
			"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
			"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
			"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
			"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
			"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
			"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
			"BASKET_URL" => $arParams["BASKET_URL"],
			"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
			"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
			//"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
			"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
			"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
			"FILTER_NAME" => $arParams["FILTER_NAME"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_FILTER" => $arParams["CACHE_FILTER"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"SET_TITLE" => $arParams["SET_TITLE"],
			"MESSAGE_404" => $arParams["MESSAGE_404"],
			"SET_STATUS_404" => $arParams["SET_STATUS_404"],
			"SHOW_404" => $arParams["SHOW_404"],
			"FILE_404" => $arParams["FILE_404"],
			"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
			"PAGE_ELEMENT_COUNT" => 80,
			"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
			"PRICE_CODE" => $arParams["PRICE_CODE"],
			"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
			"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

			"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
			"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
			"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
			"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
			"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

			"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
			"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
			"PAGER_TITLE" => $arParams["PAGER_TITLE"],
			"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
			"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
			"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
			"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
			"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
			"PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
			"PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
			"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],

			"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
			"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
			"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
			"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
			"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
			"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
			"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
			"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

			"SECTION_CODE" => $_REQUEST["SECTION_CODE"],
			"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
			"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
			"USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
			'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
			'CURRENCY_ID' => $arParams['CURRENCY_ID'],
			'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],

			'LABEL_PROP' => $arParams['LABEL_PROP'],
			'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
			'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

			'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
			'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
			'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
			'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
			'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
			'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
			'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
			'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],

			'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
			"ADD_SECTIONS_CHAIN" => "N",
			'ADD_TO_BASKET_ACTION' => $basketAction,
			'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
			'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
			'BACKGROUND_IMAGE' => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : '')
		),
		$component
	);?>
		</div>
	<?
	$GLOBALS['CATALOG_CURRENT_SECTION_ID'] = $intSectionID;
	unset($basketAction);
	?>
	<?if(!empty($description)):?>
	<div class="white description_about">
        <div class="container">
            <div class="row">
                <div>
                   	<?=$description;?>
                </div>
            </div>
        </div>
    </div>
    <?endif;?>
	</div>
</div>
<?
if($SECTION_ID > 0) {
	$ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues(6, $SECTION_ID);
	$IPROPERTY  = $ipropValues->getValues();

	$APPLICATION->SetPageProperty("title", $IPROPERTY['SECTION_META_TITLE']);
	$APPLICATION->SetPageProperty("keywords", $IPROPERTY['SECTION_META_KEYWORDS']);
	$APPLICATION->SetPageProperty("description", $IPROPERTY['SECTION_META_DESCRIPTION']);
}?>
