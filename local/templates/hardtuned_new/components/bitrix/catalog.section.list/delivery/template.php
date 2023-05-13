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

$arViewModeList = $arResult['VIEW_MODE_LIST'];

$arCurView = $arViewStyles[$arParams['VIEW_MODE']];

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

if (0 < $arResult["SECTIONS_COUNT"])
{
	foreach ($arResult['SECTIONS'] as &$arSection)
	{
		$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
		$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
?>
	<div class="block_d" id="<? echo $this->GetEditAreaId($arSection['ID']); ?>">
		<div class="title" <?if(!empty($arSection['PICTURE']['SRC'])):?>style="background: url(<?=$arSection['PICTURE']['SRC']?>) no-repeat; background-position: 40px 15px;"<?endif;?>>
			<?=$arSection['NAME']?>:
		</div>
		<?if(isset($arSection['ITEMS']) && !empty($arSection['ITEMS'])):?>
			<?foreach ($arSection['ITEMS'] as $key => $item):?>
				<div class="question">
					<div class="name"><?=$item['NAME']?><i class="fas fa-caret-down"></i></div>
					<div class="txt">
						<?=$item['PREVIEW_TEXT'];?>
					</div>
				</div>
			<?endforeach;?>
		<?endif;?>
	</div>
	<?
	}
}
?>
