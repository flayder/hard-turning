<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $USER, $FILTER_LOST;

// if(!empty($FILTER_LOST['CAR']['ID']) && $USER->IsAuthorized()) {
// 	$res = CIBlockSection::GetList(Array("SORT"=>"ASC"), Array('SECTION_ID' => $FILTER_LOST['CAR']['ID']));
// 	$arResult = array();
// 		while($ar_res = $res->GetNext()) {
// 			$arResult[] = array(
// 				'TEXT' => $ar_res['NAME'],
// 				'LINK' => $ar_res['SECTION_PAGE_URL'],
// 				'DEPTH_LEVEL' => 1,
// 				'PARAMS' => array('PICTURE' => $ar_res['PICTURE'])
// 			);
// 		}
// }


foreach ($arResult as $key => $item) {
	$param = $item['PARAMS'];

	if(!$param['UF_SHOW_MENU']) unset($arResult[$key]);
	else {
		$sec = CIBlockSection::GetList(Array("SORT"=>"ASC"), Array(
			"IBLOCK_ID" => 4,
			"SECTION_ID" => $param["SECTION_ID"],
			"UF_CHILDMENU" => 1
		), false, Array("ID", "NAME", "SECTION_PAGE_URL", "UF_*"));
		while ($section = $sec->GetNext()) {
			$sec1 = CIBlockSection::GetList(Array("SORT"=>"ASC"), Array(
				"IBLOCK_ID" => 4,
				"SECTION_ID" => $section["ID"],
				"UF_CHILDMENU" => 2
			), false, Array("ID", "NAME", "SECTION_PAGE_URL", "UF_*"));
			while ($section1 = $sec1->GetNext()) {
				$section['CHILDS_2'][] = $section1;
			}
			$arResult[$key]['CHILDS'][] = $section;
		}
	}
}

// foreach($arResult as $arItem){
// 	//print_r($arItem);
// }
?>