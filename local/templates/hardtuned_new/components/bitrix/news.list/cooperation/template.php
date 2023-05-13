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
<div class="about">
	<div class="about-bl">
		<div class="col-lg-4 discus" style="background: url(<?=CFile::GetPath($arResult['PICTURE'])?>) no-repeat;"></div>
		<div class="col-lg-8 content-a">
			<h1>Партнерам</h1>
			<ul class="simple-c">
				<?foreach($arResult["ITEMS"] as $arItem):?>
					<li>
						<a href="#block_<?=$arItem['ID']?>"><?=$arItem['NAME']?></a>
					</li>
				<?endforeach;?>
			</ul>
		</div>
	</div>
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		<div class="block-c" id="block_<?=$arItem['ID']?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<div class="title"><?=$arItem['NAME']?></div>
			<div class="wrap">
				<?=$arItem['PREVIEW_TEXT']?>
				<a href="#d-form" class="btn-applic">Перейти к заявке</a>
			</div>
		</div>
	<?endforeach;?>
</div>