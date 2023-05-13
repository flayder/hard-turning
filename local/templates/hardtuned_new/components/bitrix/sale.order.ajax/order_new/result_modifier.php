<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(!$USER->IsAuthorized()) {
	CModule::IncludeModule('iblock');
	$arFilter = array('IBLOCK_ID' => 6, 'DEPTH_LEVEL' => 1);
	$rsSect = CIBlockSection::GetList(array('name' => 'asc'), $arFilter, false, array('ID', 'NAME'));
	while($ob = $rsSect->GetNext())
	{
	 	$arResult['MARKS'][$ob['ID']] = $ob;
	}
	
	if(!session_id()) session_start();
	
	if(!empty($_SESSION['U_MODEL'])) {
		$res = CIBlockSection::GetByID($_SESSION['U_MODEL']);
			if($ar_res = $res->GetNext())
				$arResult['MODEL'] = $ar_res;
	}
	
	if(!empty($_SESSION['U_YEAR'])) {
		$res = CIBlockSection::GetByID($_SESSION['U_YEAR']);
			if($ar_res = $res->GetNext())
				$arResult['YEAR'] = $ar_res;
	}
}
foreach ($arResult['BASKET_ITEMS'] as $key => $product) {
	$db_props = CIBlockElement::GetProperty(4, $product['PRODUCT_ID'], array("sort" => "asc"), Array("CODE" => "ARTICLE"));
		if($ar_props = $db_props->Fetch())
    		$arResult['BASKET_ITEMS'][$key]['PROPS'][$ar_props['CODE']] = $ar_props;
}
if (!empty($arResult["ORDER"]) && $_GET["successful"] == "Y") {
	$dbBasketItems = CSaleBasket::GetList(
	    array(
	            "NAME" => "ASC",
	            "ID" => "ASC"
	        ),
	    array(
	        "ORDER_ID" => $arResult["ORDER"]["ID"]
	    ),
	    false,
	    false,
	    array("PRODUCT_ID")
	);
	while ($arItems = $dbBasketItems->Fetch())
	{
	    $res = CIBlockElement::GetByID($arItems["PRODUCT_ID"]);
		if($ar_res = $res->GetNext()) {
			$sec = CIBlockSection::GetList(Array(), Array("ID" => $ar_res["IBLOCK_SECTION_ID"]), false, Array("NAME"));
			if($section = $sec->GetNext())
				$ar_res["SECTION_NAME"] = $section["NAME"];

			$prop = CIBlockElement::GetProperty(4, $ar_res["ID"], Array(), Array("ID" => 75));
			if($property = $prop->Fetch()) {
				$ar_res["BRAND"] = $property["VALUE_ENUM"];
			}

			$ar_res["PRICE"] = CPrice::GetBasePrice($ar_res["ID"]);
		  	
		  	$arResult["ITEMS"][] = $ar_res;
		}
	}

} elseif(!empty($arResult["ORDER"]) && !$_GET["successful"]) {
	LocalRedirect($APPLICATION->GetCurPage() . "?ORDER_ID=" . $arResult["ORDER"]["ID"] . "&successful=Y");
}
?>