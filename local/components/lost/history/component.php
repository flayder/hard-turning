<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $USER;
CModule::IncludeModule('iblock');
CModule::IncludeModule('sale');

$arResult = array(
	"ITEMS" => array()
);

$res = CSaleOrder::GetList(Array("ID"=>"DESC"), Array('USER_ID' => $USER->GetID()), false, array("nPageSize" => 20), array(), array());
while ($order = $res->GetNext()) {
	$arBasketItems = array();
	$dbBasketItems = CSaleBasket::GetList(
	    array(
	            "NAME" => "ASC",
	            "ID" => "ASC"
	        ),
	    array(
	            "LID" => SITE_ID,
	            "ORDER_ID" => $order['ID']
	        ),
	    false,
	    false,
	    array()
	);
	while ($arItems = $dbBasketItems->Fetch())
	{
	
	    $arBasketItems[] = $arItems;
	}
	if(!empty($arBasketItems)) {
		$order['BASKET'] = $arBasketItems;
		$arResult['ITEMS'][] = $order;
	}
}

$arResult['results'] = $res;

$this->IncludeComponentTemplate();
