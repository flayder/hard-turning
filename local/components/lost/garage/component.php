<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $USER;
CModule::IncludeModule('iblock');

$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->Fetch();

$arResult = array(
	"CARS" => array(),
	"MARKS" => array()
);

$arFilter = array('IBLOCK_ID' => 4, 'SECTION_ID' => 12949, 'DEPTH_LEVEL' => 2);
$rsSect = CIBlockSection::GetList(array('name' => 'asc'), $arFilter, false, array('ID', 'NAME'));
while($ob = $rsSect->GetNext())
{
 	$arResult['MARKS'][$ob['ID']] = $ob;
}



if(!empty($arUser['UF_MARK'])) {
	if(is_array($arUser['UF_MARK'])) {
		foreach ($arUser['UF_MARK'] as $key => $choice) {
			$res = CIBlockSection::GetByID($choice);
				if($ar_res = $res->GetNext())
					$arResult['CARS']['MARKS'][] = $ar_res;
		}
	} else {
		$res = CIBlockSection::GetByID($arUser['UF_MARK']);
			if($ar_res = $res->GetNext())
				$arResult['CARS']['MARKS'][] = $ar_res;
	}
}

if(!empty($arUser['UF_MODEL'])) {
	if(is_array($arUser['UF_MODEL'])) {
		foreach ($arUser['UF_MODEL'] as $key => $choice) {
			$res = CIBlockSection::GetList(Array("SORT"=>"ASC"), Array('IBLOCK_ID' => 4, 'ID' => $choice), false, Array('UF_MODEL'));
				if($ar_res = $res->GetNext())
					$arResult['CARS']['MODELS'][] = $ar_res;
		}
	} else {
		$res = CIBlockSection::GetList(Array("SORT"=>"ASC"), Array('IBLOCK_ID' => 4, 'ID' => $arUser['UF_MODEL']), false, Array('UF_MODEL'));
			if($ar_res = $res->GetNext())
				$arResult['CARS']['MODELS'][] = $ar_res;
	}
}

if(!empty($arUser['UF_YEAR'])) {
	if(is_array($arUser['UF_YEAR'])) {
		foreach ($arUser['UF_YEAR'] as $key => $choice) {
			$res = CIBlockSection::GetByID($choice);
				if($ar_res = $res->GetNext())
					$arResult['CARS']['YEARS'][] = $ar_res;
		}
	} else {
		$res = CIBlockSection::GetByID($arUser['UF_MARK']);
			if($ar_res = $res->GetNext())
				$arResult['CARS']['YEARS'][] = $ar_res;
	}
}
foreach ($arResult['CARS']['YEARS'] as $key => $year) {
	if(!empty($year['PICTURE'])) {
		$file = CFile::ResizeImageGet($year['PICTURE'], array('width'=>100, 'height'=>50), BX_RESIZE_IMAGE_EXACT);
		$arResult['CARS']['YEARS'][$key]['PICTURE'] = $file['src'];
	}
}
$arResult['DEFAULT'] = $arUser['UF_MAIN_CAR'];
$arResult['WIN'] = unserialize($arUser['UF_WIN']);

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

//print_r($arResult);

$this->IncludeComponentTemplate();
