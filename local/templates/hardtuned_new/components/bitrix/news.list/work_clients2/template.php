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
?>
<?foreach($arResult["ITEMS"] as $arItem):?>
<?/*
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
*/?>
 <div class="col-sm-6 license">
	  <p class="name"><?echo $arItem["NAME"];?></p>
<p  class="text"><?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
			<?echo $arItem["PREVIEW_TEXT"];?>
		<?endif;?></p><div class="my-flex-cont owl-carousel owl-theme">
<?if (!empty($arItem["PROPERTIES"]["WORK_GALLERY"]["VALUE"])):?>
    <?foreach($arItem["PROPERTIES"]["WORK_GALLERY"]["VALUE"] as $photo):?>
      <div class="my-flex-box item">
<div class="image__wrapper">
  <img src="<?=CFile::GetPath($photo)?>" class="minimized" alt="клик для увеличения" />
	 </div>

</div>
    <?endforeach?>
<?endif?></div>



		</div><?endforeach;?>