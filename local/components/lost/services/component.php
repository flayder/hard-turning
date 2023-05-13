<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $USER;
CModule::IncludeModule('iblock');

$arResult = array(
	'SECTIONS' => array()
);

$items = GetIBlockSectionList(5, 0, Array("id"=>"asc"), false);
while($arItem = $items->GetNext()) {
	if(!empty($arItem['PICTURE']))
		$arItem['PICTURE'] = CFile::GetPath($arItem['PICTURE']);
	
	$arResult['SECTIONS'][] = $arItem;
}

$this->IncludeComponentTemplate();
