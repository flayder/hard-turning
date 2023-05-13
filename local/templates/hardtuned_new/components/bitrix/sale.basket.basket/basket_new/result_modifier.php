<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $USER;


$arResult['AKSESSUAR'] = [];
$magnitols = [];
$arResult['ALL_DEFAULT_MAGNITOLS'] = [];

CModule::IncludeModule('iblock');
foreach ($arResult['ITEMS']['AnDelCanBuy'] as $key => $item) {
	$db_props = CIBlockElement::GetProperty(4, $item['PRODUCT_ID'], array("sort" => "asc"), Array("CODE"=>"POKUPAUT"));
	while($ar_props = $db_props->Fetch()){
		if(!empty($ar_props['VALUE'])) {
			if(count($arResult['AKSESSUAR']) < 4) {
				$arResult['AKSESSUAR'][] = $ar_props['VALUE'];
			} else {
				break;
			}
		} 
	}

	if(is_array($item['PROPS'])) {
		$mag = false;
		$def = false;

		foreach($item['PROPS'] as $prop) {
			if($prop['CODE'] == 'MAGNITOLA') {
				$mag = true;
			}
			if($prop['CODE'] == 'DEFAULT_PRODUCT')
				$def = $prop['VALUE'];	
		}

		if($mag && !$def && !in_array($item['PRODUCT_ID'], $magnitols)) {
			$magnitols[] = $item['PRODUCT_ID'];
		}

		if($def) {
			$arResult['ALL_DEFAULT_MAGNITOLS'][$def][] = $item;
		}
	}
}
if(count($arResult['AKSESSUAR']) < 4) {
	$res = CIBlockElement::GetList(Array("ID"=>"DESC"), Array('ACTIVE' => 'Y', 'IBLOCK_ID' => 4, '!PROPERTY_POKUPAUT' => false), false, array('nTopCount' => 4), Array('ID'));
	while ($result = $res->GetNext()) {
		if(count($arResult['AKSESSUAR']) < 4) {
			$arResult['AKSESSUAR'][] = $result['ID'];
		} else {
			break;
		}
	}
}

$magnitolDone = [];

foreach($arResult['ITEMS']['AnDelCanBuy'] as $key => $basket) {
		$arResult['ITEMS']['AnDelCanBuy'][$key]['MAGNITOLA_PROPS'] = [];

		if(isset($arResult['ALL_DEFAULT_MAGNITOLS'][$basket['PRODUCT_ID']]))
			$arResult['ITEMS']['AnDelCanBuy'][$key]['MAGNITOLA_PROPS'] = $arResult['ALL_DEFAULT_MAGNITOLS'][$basket['PRODUCT_ID']];

		$ifMagnitola = false;

		if(is_array($basket['PROPS'])) {
			foreach($basket['PROPS'] as $prop) {
				if($prop['CODE'] == 'DEFAULT_PRODUCT')
					$ifMagnitola = $prop['VALUE'];
			}
		}

		if($ifMagnitola && !in_array($ifMagnitola, $magnitols) && !in_array($ifMagnitola, $magnitolDone)) {
			$magnitolDone[] = $ifMagnitola;
			$res = CIBlockElement::GetByID($ifMagnitola);

			if($ar_res = $res->GetNext()) {
				$basket['NAME'] = $ar_res['NAME'];
				
  				$basket['PRODUCT_ID'] = $ar_res['PRODUCT_ID'];
				$basket['PREVIEW_PICTURE_SRC'] = CFile::GetPath($ar_res['PREVIEW_PICTURE']);
			}

			foreach($basket['PROPS'] as $k => $prop) {
				if($prop['CODE'] == 'DEFAULT_PRODUCT')
					unset($basket['PROPS'][$k]);
			}
			

			$arResult['ITEMS']['AnDelCanBuy'][$key] = $basket;

			if(isset($arResult['ALL_DEFAULT_MAGNITOLS'][$ifMagnitola]))
				$arResult['ITEMS']['AnDelCanBuy'][$key]['MAGNITOLA_PROPS'] = $arResult['ALL_DEFAULT_MAGNITOLS'][$ifMagnitola];

		}
	}
