<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	CModule::IncludeModule("iblock");
	$tree = CIBlockSection::GetTreeList(
	 	Array('IBLOCK_ID' => 4, 'ACTIVE' => 'Y', 'GLOBAL_ACTIVE' => 'Y'),
	 	Array()
	);
	$arResult["arMap"][] = array(
		'LEVEL' => 0,
        'ID' => '123123123',
        'IS_DIR' => 'Y',
        'NAME' => 'Каталог',
        'PATH' => $_SERVER['DOCUMENT_ROOT'],
        'FULL_PATH' => '/catalog/',
        'SEARCH_PATH' => '/catalog/',
        'DESCRIPTION' => ''
	);
	while($section = $tree->GetNext()) {
		$arResult["arMap"][] = array(
			'LEVEL' => $section['DEPTH_LEVEL'],
    	    'ID' => $section['ID'],
    	    'NAME' => $section['NAME'],
    	    'PATH' => $_SERVER['DOCUMENT_ROOT'],
    	    'FULL_PATH' => $section['SECTION_PAGE_URL'],
    	    'SEARCH_PATH' => $section['SECTION_PAGE_URL'],
    	    'DESCRIPTION' => ''
		);
	}
	CModule::IncludeModule("iblock");
	$tree = CIBlockSection::GetTreeList(
	 	Array('IBLOCK_ID' => 6, 'ACTIVE' => 'Y', 'GLOBAL_ACTIVE' => 'Y'),
	 	Array()
	);
	$arResult["arMap"][] = array(
		'LEVEL' => 0,
        'ID' => '1231231232',
        'IS_DIR' => 'Y',
        'NAME' => 'Марки и модели',
        'PATH' => $_SERVER['DOCUMENT_ROOT'],
        'FULL_PATH' => '/catalog/',
        'SEARCH_PATH' => '/catalog/',
        'DESCRIPTION' => ''
	);
	while($section = $tree->GetNext()) {
		$arResult["arMap"][] = array(
			'LEVEL' => $section['DEPTH_LEVEL'],
    	    'ID' => $section['ID'],
    	    'NAME' => $section['NAME'],
    	    'PATH' => $_SERVER['DOCUMENT_ROOT'],
    	    'FULL_PATH' => $section['SECTION_PAGE_URL'],
    	    'SEARCH_PATH' => $section['SECTION_PAGE_URL'],
    	    'DESCRIPTION' => ''
		);
	}
?>