<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $USER, $FILTER_LOST;
CModule::IncludeModule('iblock');

$arResult = array(
	"CARS" => array(),
	"MARKS" => array(),
	"AUTORIZED" => ($USER->IsAuthorized()) ? "Y" : "N"
	//"AUTORIZED" => "Y"
);

$arFilter = array('IBLOCK_ID' => 4, 'SECTION_ID' => 12949, 'DEPTH_LEVEL' => 2);
$rsSect = CIBlockSection::GetList(array('name' => 'asc'), $arFilter, false, array('ID', 'NAME'));
while($ob = $rsSect->GetNext())
{
 	$arResult['MARKS'][$ob['ID']] = $ob;
}

if($_REQUEST['change'] == 'car') {
	if($arResult['AUTORIZED'] == "Y") {
		$user = new CUser;
		$arFields = array('UF_MAIN_CAR' => '');
		$user->Update($USER->GetID(), $arFields);
	}
	$_SESSION['U_MARKA'] = '';
	$_SESSION['U_MODEL'] = '';
	$_SESSION['U_YEAR'] = '';
	LocalRedirect('/');
}

// if($arResult['AUTORIZED'] == "Y")
// {
	if($_REQUEST['default'] == 'car' && !empty($_SESSION['U_YEAR'])) {
		$user = new CUser;
		$arFields = array('UF_MAIN_CAR' => $_SESSION['U_YEAR']);
		$user->Update($USER->GetID(), $arFields);
		$res = CIBlockSection::GetByID($_SESSION['U_YEAR']);
			if($ar_res = $res->GetNext()) {
				LocalRedirect($ar_res['SECTION_PAGE_URL']);
			}
	}
	$rsUser = CUser::GetByID($USER->GetID());
	$arUser = $rsUser->Fetch();

	$FILTER_LOST['USER']['UF_MAIN_CAR'] = $arUser['UF_MAIN_CAR'];

	if(!empty($arUser['UF_MAIN_CAR'])) {
		$res = CIBlockSection::GetByID($arUser['UF_MAIN_CAR']);
			if($ar_res = $res->GetNext()) {
				$file = CFile::ResizeImageGet($ar_res['PICTURE'], array('width'=>100, 'height'=>50), BX_RESIZE_IMAGE_EXACT);
				$ar_res['PICTURE'] = $file['src'];
				$arResult['UF_MAIN_CAR'] = $ar_res;
				$FILTER_LOST['CAR'] = $ar_res;

				$ress = CIBlockSection::GetByID($ar_res['IBLOCK_SECTION_ID']);
					if($ar_ress = $ress->GetNext()) {
						$file = CFile::ResizeImageGet($ar_ress['PICTURE'], array('width'=>100, 'height'=>50), BX_RESIZE_IMAGE_EXACT);
						$ar_ress['PICTURE'] = $file['src'];
						$arResult['UF_MAIN_CAR']['MODEL'] = $ar_ress;
						$FILTER_LOST['CAR']['MODEL'] = $ar_ress;

						$resss = CIBlockSection::GetByID($ar_ress['IBLOCK_SECTION_ID']);
						if($ar_resss = $resss->GetNext()) {
							$arResult['UF_MAIN_CAR']['MARK'] = $ar_resss;
							$FILTER_LOST['CAR']['MARK'] = $ar_resss;
						}
					}
			}
	}

// }

if(!empty($_SESSION['U_MODEL'])) {
	$res = CIBlockSection::GetByID($_SESSION['U_MODEL']);
		if($ar_res = $res->GetNext()) {
			$arResult['MODEL'] = $ar_res;
		}
}


if(!empty($_SESSION['U_YEAR'])) {
	$res = CIBlockSection::GetByID($_SESSION['U_YEAR']);
		if($ar_res = $res->GetNext()) {
			$file = CFile::ResizeImageGet($ar_res['PICTURE'], array('width'=>100, 'height'=>50), BX_RESIZE_IMAGE_EXACT);
				$ar_res['PICTURE'] = $file['src'];
			$arResult['YEAR'] = $ar_res;
			if($arResult['AUTORIZED'] == "N") {
				$arResult['UF_MAIN_CAR'] = $ar_res;
				$FILTER_LOST['CAR'] = $ar_res;

				$ress = CIBlockSection::GetByID($ar_res['IBLOCK_SECTION_ID']);
					if($ar_ress = $ress->GetNext()) {
						$file = CFile::ResizeImageGet($ar_ress['PICTURE'], array('width'=>100, 'height'=>50), BX_RESIZE_IMAGE_EXACT);
						$ar_ress['PICTURE'] = $file['src'];
						$arResult['UF_MAIN_CAR']['MODEL'] = $ar_ress;
						$FILTER_LOST['CAR']['MODEL'] = $ar_ress;

						$resss = CIBlockSection::GetByID($ar_ress['IBLOCK_SECTION_ID']);
						if($ar_resss = $resss->GetNext()) {
							$arResult['UF_MAIN_CAR']['MARK'] = $ar_resss;
							$FILTER_LOST['CAR']['MARK'] = $ar_resss;
						}
					}
			}
		}
}
// $page = $APPLICATION->GetCurPage();
// if(strpos($page, 'cat/')) {
// 	$arr = explode('/', $page);
// 	foreach ($arr as $key => $v) {
// 		if($v != 'cat' && !empty($v)) {
// 			$FILTER_LOST['PAGE_CODE'] = $v;
// 		}
// 	}
// }

$this->IncludeComponentTemplate();
