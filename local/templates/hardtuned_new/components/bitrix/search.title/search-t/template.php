<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

if($SESSION['SEARCH_ID']) $SESSION['SEARCH_ID'] = rand(5, 20);
else 
	$SESSION['SEARCH_ID'] = rand(5, 15);

?>
<?
$INPUT_ID = trim($arParams["~INPUT_ID"]);
//if(strlen($INPUT_ID) <= 0)
	$INPUT_ID = "title-search-input".$SESSION['SEARCH_ID'];
$INPUT_ID = CUtil::JSEscape($INPUT_ID);

$CONTAINER_ID = trim($arParams["~CONTAINER_ID"]);
//if(strlen($CONTAINER_ID) <= 0)
	$CONTAINER_ID = "title-search".$SESSION['SEARCH_ID'];

$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);

if($arParams["SHOW_INPUT"] !== "N"):?>
	<div id="<?echo $CONTAINER_ID?>">
	<form action="<?echo $arResult["FORM_ACTION"]?>" class="search_input">
		<input id="<?echo $INPUT_ID?>" type="text" name="q" class="search" placeholder="Поиск по каталогу" value="" size="40" maxlength="50" autocomplete="off" /><input name="s" type="submit" class="btn-search" value="" />
	</form>
	</div>
<?endif?>
