<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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